<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Ternak;
use App\Models\Kandang;
use App\Models\Abk;

class LogbookController extends Controller
{
    /**
     * Pastikan user sudah login (middleware 'auth' sudah di route mitra)
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar semua logbook kejadian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Logbook::with(['ternak', 'kandangLama', 'kandangBaru'])
                        ->orderByDesc('tanggal_kejadian');
        
        // Logika sederhana untuk pencarian
        if ($search) {
            $query->where('kejadian', 'like', '%' . $search . '%')
                  ->orWhere('ternak_tag_number', 'like', '%' . $search . '%');
        }

        $logbooks = $query->paginate(15); 

        return view('mitra.logbooks.index', compact('logbooks', 'search'));
    }

    /**
     * Menampilkan form untuk membuat logbook baru.
     */
    public function create()
    {
        // Data yang dibutuhkan untuk dropdown di form
        $ternaks = Ternak::select('tag_number', 'kandang_id')->get();
        $kandangs = Kandang::select('kandang_id')->get();
        $kejadianList = ['Melahirkan', 'Pindah Kandang', 'Pindah Tag', 'Sakit', 'Mati', 'Kastrasi', 'Lain-lain'];
        $abkList = Abk::select('name')->get(); 

        return view('mitra.logbooks.model.create', compact(
            'ternaks',
            'kandangs',
            'kejadianList',
            'abkList'
        ));
    }

    /**
     * Menyimpan data logbook baru.
     */
    public function store(Request $request)
    {
        $rules = [
            'tanggal_kejadian' => 'required|date',
            'ternak_tag_number' => 'required|exists:ternaks,tag_number',
            'kejadian' => 'required|string|max:255',
            'keterangan' => 'nullable|string',

            'kandang_baru_id' => 'nullable|exists:kandang,kandang_id',
           
            'qty_anak' => 'nullable|integer|min:0',
            'bb_lahir' => 'nullable|numeric|min:0',
      
        ];

        $validatedData = $request->validate($rules);
        $data = $request->all();

       
        $ternak = Ternak::where('tag_number', $validatedData['ternak_tag_number'])->first();
        if ($ternak) {
           
            $data['kandang_lama_id'] = $ternak->kandang_id; 
            $data['jenis_ternak'] = $ternak->jenisDomba->name ?? $ternak->jenisKambing->name ?? 'N/A'; // Asumsi
            $data['sex'] = $ternak->gender;
        }

       
        if ($data['kejadian'] == 'Pindah Kandang' && $request->filled('kandang_baru_id')) {
            $ternak->kandang_id = $data['kandang_baru_id'];
            $ternak->save();
        }

     
        Logbook::create($data);

        return redirect()->route('logbooks.index')->with('success', 'Catatan kejadian berhasil ditambahkan!');
    }

  
    public function show(Logbook $logbook) 
    {
        return view('mitra.logbooks.model.show', compact('logbook'));
    }

    public function edit(Logbook $logbook) 
    {
       
        $ternaks = Ternak::select('tag_number', 'kandang_id')->get();
        $kandangs = Kandang::select('kandang_id')->get();
        $kejadianList = ['Melahirkan', 'Pindah Kandang', 'Pindah Tag', 'Sakit', 'Mati', 'Kastrasi', 'Lain-lain'];
        $abkList = Abk::select('name')->get(); 

        return view('mitra.logbooks.model.edit', compact('logbook', 'ternaks', 'kandangs', 'kejadianList', 'abkList'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        
        $rules = [
            'tanggal_kejadian' => 'required|date',
            'ternak_tag_number' => 'required|exists:ternaks,tag_number',
            'kejadian' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'kandang_baru_id' => 'nullable|exists:kandang,kandang_id',
            'qty_anak' => 'nullable|integer|min:0',
            'bb_lahir' => 'nullable|numeric|min:0',
            
        ];

        $validatedData = $request->validate($rules);
        $data = $request->all();

        
        $ternak = Ternak::where('tag_number', $validatedData['ternak_tag_number'])->first();
        if ($ternak) {
            $data['kandang_lama_id'] = $ternak->kandang_id;
            $data['jenis_ternak'] = $ternak->jenisDomba->name ?? $ternak->jenisKambing->name ?? 'N/A'; 
            $data['sex'] = $ternak->gender;
        }

       
        if ($data['kejadian'] == 'Pindah Kandang' && $request->filled('kandang_baru_id')) {
            $ternak->kandang_id = $data['kandang_baru_id'];
            $ternak->save();
        }
        
        $logbook->update($data);

        return redirect()->route('logbooks.index')->with('success', 'Catatan kejadian berhasil diperbarui!');
    }

    public function destroy(Logbook $logbook)
    {
        $logbook->delete();
        return redirect()->route('logbooks.index')->with('success', 'Catatan kejadian berhasil dihapus!');
    }
}
