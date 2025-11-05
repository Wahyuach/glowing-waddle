<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investor; // Import model Investor
use Illuminate\Validation\ValidationException; // Import ValidationException
use Illuminate\Support\Facades\Validator; // Import Validator Facade

class InvestorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource (Investor).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $showEntries = $request->input('show_entries', 10);

        $query = Investor::query();

        // Apply search filter if search query is present
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        $investors = $query->paginate($showEntries)->withQueryString();

        return view('mitra.investor.index', compact('investors', 'search', 'showEntries'));
    }

    /**
     * Show the form for creating a new resource (Investor).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('mitra.investor.model.create');
    }

    /**
     * Store a newly created resource (Investor) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Investor::create($request->all());

        return redirect()->route('investor.index')->with('success', 'Data Investor berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (Investor).
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $investor = Investor::findOrFail($id);
        return view('mitra.investor.model.show', compact('investor'));
    }

    /**
     * Show the form for editing the specified resource (Investor).
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $investor = Investor::findOrFail($id);
        return view('mitra.investor.model.edit', compact('investor'));
    }

    /**
     * Update the specified resource (Investor) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $investor = Investor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $investor->update($request->all());

        return redirect()->route('investor.index')->with('success', 'Data Investor berhasil diperbarui!');
    }

    /**
     * Remove the specified resource (Investor) from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $investor = Investor::findOrFail($id);
        $investor->delete();

        return redirect()->route('investor.index')->with('success', 'Data Investor berhasil dihapus!');
    }

    /**
     * Import data Investor dari file CSV.
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
        $expectedHeaders = ['name', 'phone_number', 'address']; // Tanpa photo_path

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
                'name' => 'required|string|max:255',
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $errors[] = "Baris dilewati karena validasi gagal untuk data: " . implode(',', $row) . " - Errors: " . implode(', ', $validator->errors()->all());
                $skippedCount++;
                continue;
            }

            try {
                Investor::create($rowData);
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
            return redirect()->route('investor.index')->with('warning', $message)->withErrors(['import_errors' => $errors]);
        }

        return redirect()->route('investor.index')->with('success', $message);
    }
}
