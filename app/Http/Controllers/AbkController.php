<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abk;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AbkController extends Controller
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
     * Display a listing of the resource (ABK).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $showEntries = $request->input('show_entries', 10);

        $query = Abk::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        $abks = $query->paginate($showEntries)->withQueryString();

        return view('mitra.abk.index', compact('abks', 'search', 'showEntries'));
    }

    /**
     * Show the form for creating a new resource (ABK).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('mitra.abk.model.create');
    }

    /**
     * Store a newly created resource (ABK) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo_path' => 'nullable|string',
        ]);

        if (!empty($data['photo_path']) && Str::contains($data['photo_path'], '/file/d/')) {
            $parts = explode('/', $data['photo_path']);
            $fileID = $parts[5];
           
            $data['photo_path'] = 'https://drive.google.com/thumbnail?id=' . $fileID;
        }

        
        Abk::create($data);

        return redirect()->route('abk.index')->with('success', 'Data Karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (ABK).
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $abk = Abk::findOrFail($id);
        return view('mitra.abk.model.show', compact('abk'));
    }

    /**
     * Show the form for editing the specified resource (ABK).
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $abk = Abk::findOrFail($id);
        return view('mitra.abk.model.edit', compact('abk'));
    }

    /**
     * Update the specified resource (ABK) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $abk = Abk::findOrFail($id);

      
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo_path' => 'nullable|string',
        ]);

       
        if (!empty($data['photo_path']) && Str::contains($data['photo_path'], '/file/d/')) {
      
            $parts = explode('/', $data['photo_path']);
            
            $fileID = $parts[5];
      
            $data['photo_path'] = 'https://drive.google.com/thumbnail?id=' . $fileID;
        }

      
        $abk->update($data);

        return redirect()->route('abk.index')->with('success', 'Data Karyawan berhasil diperbarui!');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $abk = Abk::findOrFail($id);
        $abk->delete();

        return redirect()->route('abk.index')->with('success', 'Data Karyawan berhasil dihapus!');
    }


    public function import(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048', 
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        
        $header = array_map('trim', array_map('strtolower', array_shift($data))); // Trim dan lowercase header

        
        $expectedHeaders = ['name', 'phone_number', 'address', 'photo_path'];

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

            // Validasi data 
            $validator = Validator::make($rowData, [ 
                'name' => 'required|string|max:255',
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'photo_path' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $errors[] = "Baris dilewati karena validasi gagal untuk data: " . implode(',', $row) . " - Errors: " . implode(', ', $validator->errors()->all());
                $skippedCount++;
                continue;
            }

            
            if (!empty($rowData['photo_path']) && Str::contains($rowData['photo_path'], '/file/d/')) {
                $parts = explode('/', $rowData['photo_path']);
                $fileID = $parts[5];
                $rowData['photo_path'] = 'https://drive.google.com/thumbnail?id=' . $fileID;
            }
            try {
                
                Abk::create($rowData);
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
            return redirect()->route('abk.index')->with('warning', $message)->withErrors(['import_errors' => $errors]);
        }

        return redirect()->route('abk.index')->with('success', $message);
    }
}
