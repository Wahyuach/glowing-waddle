<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kavling;
use App\Models\Investor; // Untuk dropdown Investor
use App\Models\Abk;      // Untuk dropdown ABK
use Illuminate\Validation\ValidationException; // Import ValidationException
use Illuminate\Support\Facades\Validator; // Import Validator Facade

class KavlingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $showEntries = $request->input('show_entries', 10);

        // Eager load 'kandangs.ternaks' untuk mendukung accessor 'jumlah_populasi_kandang'
        $query = Kavling::with(['investor', 'abk', 'kandangs.ternaks']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_kavling', 'like', '%' . $search . '%')
                  ->orWhere('kapasitas', 'like', '%' . $search . '%')
                  ->orWhere('status_kepemilikan', 'like', '%' . $search . '%')
                  ->orWhereHas('investor', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('abk', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $kavlings = $query->paginate($showEntries)->withQueryString();

        $investors = Investor::all();
        $abks = Abk::all();

        return view('admin.kavling.index', compact('kavlings', 'search', 'showEntries', 'investors', 'abks'));
    }

    public function create()
    {
        $investors = Investor::all();
        $abks = Abk::all();
        return view('admin.kavling.model.create', compact('investors', 'abks'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'no_kavling' => 'required|string|max:255|unique:kavling,no_kavling',
            'kapasitas' => 'required|integer|min:0',
            'status_kepemilikan' => 'required|string|max:255',
            'investor_id' => 'nullable|exists:investors,id',
            'abk_id' => 'nullable|exists:abk,id',
        ]);

        Kavling::create($request->all());

        return redirect()->route('kavling.index')->with('success', 'Data Kavling berhasil ditambahkan!');
    }

    public function show(string $no_kavling)
    {
        $kavling = Kavling::with(['investor', 'abk', 'kandangs.ternaks'])->findOrFail($no_kavling);
        
        return view('admin.kavling.model.show', compact('kavling'));
    }

    public function edit(string $no_kavling)
    {
        $kavling = Kavling::with(['investor', 'abk', 'kandangs.ternaks'])->findOrFail($no_kavling);
        $investors = Investor::all();
        $abks = Abk::all();
        return view('admin.kavling.model.edit', compact('kavling', 'investors', 'abks'));
    }

    public function update(Request $request, string $no_kavling): \Illuminate\Http\RedirectResponse
    {
        $kavling = Kavling::findOrFail($no_kavling);

        $request->validate([
            'kapasitas' => 'required|integer|min:0',
            'status_kepemilikan' => 'required|string|max:255',
            'investor_id' => 'nullable|exists:investors,id',
            'abk_id' => 'nullable|exists:abk,id',
        ]);

        $kavling->update($request->all());

        return redirect()->route('kavling.index')->with('success', 'Data Kavling berhasil diperbarui!');
    }
    
    public function destroy(string $no_kavling): \Illuminate\Http\RedirectResponse
    {
        $kavling = Kavling::findOrFail($no_kavling);
        $kavling->delete();

        return redirect()->route('kavling.index')->with('success', 'Data Kavling berhasil dihapus!');
    }

    /**
     * Import data Kavling dari file CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048', // Max 2MB
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Asumsi baris pertama adalah header
        $header = array_map('trim', array_map('strtolower', array_shift($data))); // Trim dan lowercase header

        // Kolom yang diharapkan dari CSV
        $expectedHeaders = ['no_kavling', 'kapasitas', 'status_kepemilikan', 'investor_id', 'abk_id'];

        // Validasi header
        if (count(array_diff($expectedHeaders, $header)) > 0) {
            throw ValidationException::withMessages([
                'csv_file' => 'Format header CSV tidak sesuai. Harap gunakan: ' . implode(', ', $expectedHeaders),
            ]);
        }

        $importedCount = 0;
        $skippedCount = 0;
        $errors = [];

        foreach ($data as $row) {
            if (count($row) !== count($header)) {
                $errors[] = "Baris dilewati karena jumlah kolom tidak cocok: " . implode(',', $row);
                $skippedCount++;
                continue;
            }

            $rowData = array_combine($header, $row);

            // Validasi data per baris
            $validator = Validator::make($rowData, [
                'no_kavling' => 'required|string|max:255|unique:kavling,no_kavling',
                'kapasitas' => 'required|integer|min:0',
                'status_kepemilikan' => 'required|string|max:255',
                'investor_id' => 'nullable|exists:investors,id',
                'abk_id' => 'nullable|exists:abk,id',
            ]);

            if ($validator->fails()) {
                $errors[] = "Baris dilewati karena validasi gagal untuk data: " . implode(',', $row) . " - Errors: " . implode(', ', $validator->errors()->all());
                $skippedCount++;
                continue;
            }

            try {
                Kavling::create($rowData);
                $importedCount++;
            } catch (\Exception $e) {
                $errors[] = "Baris dilewati karena kesalahan penyimpanan database: " . implode(',', $row) . " - Error: " . $e->getMessage();
                $skippedCount++;
            }
        }

        $message = "Impor selesai. Berhasil mengimpor {$importedCount} data.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} data dilewati.";
        }

        if (!empty($errors)) {
            return redirect()->route('kavling.index')->with('warning', $message)->withErrors(['import_errors' => $errors]);
        }

        return redirect()->route('kavling.index')->with('success', $message);
    }
}
