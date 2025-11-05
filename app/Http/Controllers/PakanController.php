<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakan; // Import model Pakan
use App\Models\TipePakan; // Import model TipePakan (untuk dropdown)

class PakanController extends Controller
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
     * Display a listing of the resource (Pakan).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $showEntries = $request->input('show_entries', 10);

        $query = Pakan::with('tipePakan');

        // Apply search filter if search query is present
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('unit', 'like', '%' . $search . '%')
                  ->orWhereHas('tipePakan', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $pakans = $query->paginate($showEntries)->withQueryString(); // Paginate results and maintain query string

        return view('mitra.pakan.index', compact('pakans', 'search', 'showEntries'));
    }

    /**
     * Show the form for creating a new resource (Pakan).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $tipePakans = TipePakan::all(); // Ambil semua tipe pakan untuk dropdown
        return view('mitra.pakan.model.create', compact('tipePakans'));
    }

    /**
     * Store a newly created resource (Pakan) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tipe_pakan_id' => 'nullable|exists:tipe_pakan,id', // Validasi foreign key
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Pakan::create($request->all());

        return redirect()->route('pakan.index')->with('success', 'Data Pakan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (Pakan).
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $pakan = Pakan::with('tipePakan')->findOrFail($id); // Temukan Pakan berdasarkan ID dengan relasi
        return view('mitra.pakan.model.show', compact('pakan'));
    }

    /**
     * Show the form for editing the specified resource (Pakan).
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $pakan = Pakan::findOrFail($id); // Temukan Pakan berdasarkan ID
        $tipePakans = TipePakan::all(); // Ambil semua tipe pakan untuk dropdown
        return view('mitra.pakan.model.edit', compact('pakan', 'tipePakans'));
    }

    /**
     * Update the specified resource (Pakan) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $pakan = Pakan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'tipe_pakan_id' => 'nullable|exists:tipe_pakan,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $pakan->update($request->all());

        return redirect()->route('pakan.index')->with('success', 'Data Pakan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource (Pakan) from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $pakan = Pakan::findOrFail($id);
        $pakan->delete();

        return redirect()->route('pakan.index')->with('success', 'Data Pakan berhasil dihapus!');
    }
}
