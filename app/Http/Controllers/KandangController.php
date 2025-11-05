<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kandang;
use App\Models\TipeKandang;
use App\Models\Kavling;

class KandangController extends Controller
{
    /**
     * Membuat instance controller baru.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar Kandang untuk Kavling tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kavling  $kavling
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, Kavling $kavling)
    {
        $search = $request->input('search');
        $showEntries = $request->input('show_entries', 10);

        $query = $kavling->kandangs()->with('tipeKandang', 'ternaks');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kandang_id', 'like', '%' . $search . '%')
                  ->orWhere('kapasitas', 'like', '%' . $search . '%')
                  ->orWhereHas('tipeKandang', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhere('notes', 'like', '%' . $search . '%');
            });
        }

        $kandangs = $query->paginate($showEntries)->withQueryString();

        return view('mitra.kavling.kandang.index', compact('kavling', 'kandangs', 'search', 'showEntries'));
    }

    /**
     * Menampilkan formulir untuk membuat Kandang baru.
     *
     * @param  \App\Models\Kavling  $kavling
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Kavling $kavling)
    {
        $tipeKandangs = TipeKandang::all();
        return view('mitra.kavling.kandang.model.create', compact('kavling', 'tipeKandangs'));
    }

    /**
     * Menyimpan Kandang yang baru dibuat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kavling  $kavling
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Kavling $kavling): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'kandang_id' => 'required|string|max:255|unique:kandang,kandang_id',
            'tipe_kandang_id' => 'nullable|exists:tipe_kandang,id',
            'kapasitas' => 'required|integer|min:0',
            // 'current_population' dihapus dari validasi karena itu adalah accessor
            'notes' => 'nullable|string',
        ]);

        $kandangData = $request->except('current_population'); // Pastikan tidak mencoba menyimpan ini

        $kavling->kandangs()->create($kandangData);
        // --- Akhir perubahan ---

        return redirect()->route('kavling.kandang.index', $kavling)->with('success', 'Data Kandang berhasil ditambahkan!');
    }

    /**
     * Menampilkan Kandang yang ditentukan.
     *
     * @param  \App\Models\Kavling  $kavling
     * @param  \App\Models\Kandang  $kandang
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Kavling $kavling, Kandang $kandang)
    {
        $kandang->load('tipeKandang', 'ternaks');
        return view('mitra.kavling.kandang.model.show', compact('kavling', 'kandang'));
    }

    /**
     * Menampilkan formulir untuk mengedit Kandang yang ditentukan.
     *
     * @param  \App\Models\Kavling  $kavling
     * @param  \App\Models\Kandang  $kandang
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Kavling $kavling, Kandang $kandang)
    {
        $kandang->load('ternaks');
        $tipeKandangs = TipeKandang::all();
        return view('mitra.kavling.kandang.model.edit', compact('kavling', 'kandang', 'tipeKandangs'));
    }

    /**
     * Memperbarui Kandang yang ditentukan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kavling  $kavling
     * @param  \App\Models\Kandang  $kandang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Kavling $kavling, Kandang $kandang): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'tipe_kandang_id' => 'nullable|exists:tipe_kandang,id',
            'kapasitas' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $kandangData = $request->except('current_population');
        $kandang->update($kandangData);

        return redirect()->route('kavling.kandang.index', $kavling)->with('success', 'Data Kandang berhasil diperbarui!');
    }

    /**
     * Menghapus Kandang yang ditentukan.
     *
     * @param  \App\Models\Kavling  $kavling
     * @param  \App\Models\Kandang  $kandang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Kavling $kavling, Kandang $kandang): \Illuminate\Http\RedirectResponse
    {
        $kandang->delete();

        return redirect()->route('kavling.kandang.index', $kavling)->with('success', 'Data Kandang berhasil dihapus!');
    }
}