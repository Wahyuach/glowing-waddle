<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ternak;
use App\Models\Kandang;
use App\Models\Kategori;
use App\Models\Species;
use App\Models\Kondisi;
use App\Models\Status;
use App\Models\SubKategori;
use App\Models\TipeDomba;
use App\Models\JenisDomba;
use App\Models\WeightHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Investor;
class TernakController extends Controller
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
     * Private helper method to calculate and update upweight for a Ternak.
     *
     * @param Ternak $ternak
     * @return void
     */
    private function updateTernakUpweight(Ternak $ternak): void
    {
        // Ambil 2 riwayat bobot terbaru
        $histories = $ternak->weightHistories()
            ->orderByDesc('measurement_date')
            ->orderByDesc('id')
            ->limit(2)
            ->get();
        if ($histories->count() < 2) {
            $ternak->upweight = null;
        } else {
            // Karena orderByDesc, indeks 0 = terbaru, indeks 1 = sebelumnya
            $latestWeight = $histories[0]->weight;
            $previousWeight = $histories[1]->weight;
            $ternak->upweight = $latestWeight - $previousWeight;
        }
        $ternak->save();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $showEntries = $request->input('show_entries', 10);

        $filterSpecies = $request->input('filter_species');
        $filterKategori = $request->input('filter_kategori');
        $filterGender = $request->input('filter_gender');
        $filterKandang = $request->input('filter_kandang');
        $filterTipeDomba = $request->input('filter_tipe_domba');
        $filterJenisDomba = $request->input('filter_jenis_domba');
        $filterKondisi = $request->input('filter_kondisi');
        $filterStatus = $request->input('filter_status');
        // Filter baru: Terakhir Diukur (Rentang Tanggal)
        $filterLastMeasuredDateStart = $request->input('filter_last_measured_date_start');
        $filterLastMeasuredDateEnd = $request->input('filter_last_measured_date_end');


        $query = Ternak::with([
            'kandang',
            'kategori',
            'species',
            'kondisi',
            'status',
            'tipeDomba',
            'jenisDomba',
            'subKategori'
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tag_number', 'like', '%' . $search . '%')
                    ->orWhere('gender', 'like', '%' . $search . '%')
                    ->orWhere('usia_masuk_dalam_bulan', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('species', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('tipeDomba', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jenisDomba', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kandang', function ($q) use ($search) {
                        $q->where('kandang_id', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kondisi', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('status', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($filterSpecies) {
            $query->where('species_id', $filterSpecies);
        }
        if ($filterKategori) {
            $query->where('kategori_id', $filterKategori);
        }
        if ($filterGender) {
            $query->where('gender', $filterGender);
        }
        if ($filterKandang) {
            $query->where('kandang_id', $filterKandang);
        }
        if ($filterTipeDomba) {
            $query->where('tipe_domba_id', $filterTipeDomba);
        }
        if ($filterJenisDomba) {
            $query->where('jenis_domba_id', $filterJenisDomba);
        }
        if ($filterKondisi) {
            $query->where('kondisi_id', $filterKondisi);
        }
        if ($filterStatus) {
            $query->where('status_id', $filterStatus);
        }
        // Terapkan filter 'Terakhir Diukur' (rentang tanggal)
        if ($filterLastMeasuredDateStart && $filterLastMeasuredDateEnd) {
            $query->whereBetween('last_weight_date', [$filterLastMeasuredDateStart, $filterLastMeasuredDateEnd]);
        } elseif ($filterLastMeasuredDateStart) {
            $query->whereDate('last_weight_date', '>=', $filterLastMeasuredDateStart);
        } elseif ($filterLastMeasuredDateEnd) {
            $query->whereDate('last_weight_date', '<=', $filterLastMeasuredDateEnd);
        }

        if ($showEntries === 'all') {
            $ternaks = $query->get();
        } else {
            $ternaks = $query->paginate($showEntries)->withQueryString();
        }

        $speciesList = Species::all();
        $kategoriList = Kategori::all();
        $subKategoriList = SubKategori::all();
        $tipeDombaList = TipeDomba::all();
        $jenisDombaList = JenisDomba::all();
        $kondisiList = Kondisi::all();
        $statusList = Status::all();
        $kandangList = Kandang::all();

        $speciesFilterList = $speciesList;
        $kategoriFilterList = $kategoriList;
        $subKategoriFilterList = $subKategoriList;
        $kandangFilterList = $kandangList;
        $tipeDombaFilterList = $tipeDombaList;
        $jenisDombaFilterList = $jenisDombaList;
        $kondisiFilterList = $kondisiList;
        $statusFilterList = $statusList;

        return view('admin.ternak.index', compact(
            'ternaks',
            'search',
            'showEntries',
            'speciesList',
            'kategoriList',
            'subKategoriList',
            'tipeDombaList',
            'jenisDombaList',
            'kondisiList',
            'statusList',
            'kandangList',
            'filterSpecies',
            'filterKategori',
            'filterGender',
            'filterKandang',
            'filterTipeDomba',
            'filterJenisDomba',
            'filterKondisi',
            'filterStatus',
            'filterLastMeasuredDateStart', // Tambahkan ini
            'filterLastMeasuredDateEnd',   // Tambahkan ini
            'speciesFilterList',
            'kategoriFilterList',
            'subKategoriFilterList',
            'kandangFilterList',
            'tipeDombaFilterList',
            'jenisDombaFilterList',
            'kondisiFilterList',
            'statusFilterList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $kandangs = Kandang::all();
        $kategoris = Kategori::all();
        $species = Species::all();
        $kondisis = Kondisi::all();
        $statuses = Status::all();
        $subKategoris = SubKategori::all();
        $parents = Ternak::select('tag_number')->get();
        $tipeDombas = TipeDomba::all();
        $jenisDombas = JenisDomba::all();

        return view('admin.ternak.model.create', compact('kandangs', 'kategoris', 'species', 'kondisis', 'statuses', 'subKategoris', 'parents', 'tipeDombas', 'jenisDombas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'tag_number' => 'required|string|max:255|unique:ternaks,tag_number',
            'species_id' => 'nullable|exists:species,id',
            'kategori_id' => 'nullable|exists:kategori,id',
            'sub_kategori_id' => 'nullable|exists:sub_kategori,id',
            'tipe_domba_id' => 'nullable|exists:tipe_domba,id',
            'jenis_domba_id' => 'nullable|exists:jenis_domba,id',
            'gender' => 'required|in:Jantan,Betina',
            'date_of_birth' => 'nullable|date',
            'date_of_entry' => 'nullable|date',
            'usia_masuk_dalam_bulan' => 'nullable|integer|min:0',
            'entry_weight' => 'nullable|numeric',
            'current_weight' => 'nullable|numeric',
            'last_weight_date' => 'nullable|date',
            'kondisi_id' => 'nullable|exists:kondisi,id',
            'status_id' => 'nullable|exists:status,id',
            'kandang_id' => 'nullable|exists:kandang,kandang_id',
            'dam_tag_number' => 'nullable|exists:ternaks,tag_number',
            'sire_tag_number' => 'nullable|exists:ternaks,tag_number',
            'notes' => 'nullable|string',
            'photo_path' => 'nullable|string',
        ]);

        $data = $request->all();

        $data['umur_hari'] = $request->input('date_of_birth') ? Carbon::parse($request->input('date_of_birth'))->diffInDays(Carbon::now()) : null;
        $data['hari_di_peternakan'] = $request->input('date_of_entry') ? Carbon::parse($request->input('date_of_entry'))->diffInDays(Carbon::now()) : null;

        $ternak = Ternak::create($data);

        // Jika current_weight diisi, buat history dan set last_weight_date & upweight
        if ($ternak && $request->filled('current_weight')) {
            $lastWeightDate = $request->input('last_weight_date') ? Carbon::parse($request->input('last_weight_date')) : Carbon::now();

            WeightHistory::create([
                'ternak_tag_number' => $ternak->tag_number,
                'weight' => $request->current_weight,
                'measurement_date' => $lastWeightDate,
            ]);

            $ternak->last_weight_date = $lastWeightDate;
            $this->updateTernakUpweight($ternak); // Hitung dan simpan upweight
        }

        return redirect()->route('ternak.index')->with('success', 'Data ternak berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $tag_number
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(string $tag_number)
    {
        $ternak = Ternak::with(['kandang', 'kategori', 'species', 'kondisi', 'status', 'dam', 'sire', 'subKategori', 'tipeDomba', 'jenisDomba', 'weightHistories'])->find($tag_number);

        if (!$ternak) {
            abort(404, 'Data Ternak tidak ditemukan.');
        }

        $weightHistories = $ternak->weightHistories
            ->sortByDesc('measurement_date')
            ->sortByDesc('id');
        return view('admin.ternak.model.show', compact('ternak', 'weightHistories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $tag_number
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(string $tag_number)
    {
        $ternak = Ternak::find($tag_number);

        if (!$ternak) {
            abort(404, 'Data Ternak tidak ditemukan.');
        }

        $kandangs = Kandang::all();
        $kategoris = Kategori::all();
        $species = Species::all();
        $kondisis = Kondisi::all();
        $statuses = Status::all();
        $subKategoris = SubKategori::all();
        $parents = Ternak::select('tag_number')->get();
        $tipeDombas = TipeDomba::all();
        $jenisDombas = JenisDomba::all();

        return view('admin.ternak.model.edit', compact('ternak', 'kandangs', 'kategoris', 'species', 'kondisis', 'statuses', 'subKategoris', 'parents', 'tipeDombas', 'jenisDombas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tag_number
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $tag_number): \Illuminate\Http\RedirectResponse
    {
        $ternak = Ternak::find($tag_number);

        if (!$ternak) {
            abort(404, 'Data Ternak tidak ditemukan.');
        }

        $request->validate([
            'species_id' => 'nullable|exists:species,id',
            'kategori_id' => 'nullable|exists:kategori,id',
            'sub_kategori_id' => 'nullable|exists:sub_kategori,id',
            'tipe_domba_id' => 'nullable|exists:tipe_domba,id',
            'jenis_domba_id' => 'nullable|exists:jenis_domba,id',
            'gender' => 'required|in:Jantan,Betina',
            'date_of_birth' => 'nullable|date',
            'date_of_entry' => 'nullable|date',
            'usia_masuk_dalam_bulan' => 'nullable|integer|min:0',
            'entry_weight' => 'nullable|numeric',
            'current_weight' => 'nullable|numeric',
            'last_weight_date' => 'nullable|date',
            'kondisi_id' => 'nullable|exists:kondisi,id',
            'status_id' => 'nullable|exists:status,id',
            'kandang_id' => 'nullable|exists:kandang,kandang_id',
            'dam_tag_number' => 'nullable|exists:ternaks,tag_number',
            'sire_tag_number' => 'nullable|exists:ternaks,tag_number',
            'notes' => 'nullable|string',
            'photo_path' => 'nullable|string',
        ]);

        $data = $request->all();

        $data['umur_hari'] = $request->input('date_of_birth') ? Carbon::parse($request->input('date_of_birth'))->diffInDays(Carbon::now()) : null;
        $data['hari_di_peternakan'] = $request->input('date_of_entry') ? Carbon::parse($request->input('date_of_entry'))->diffInDays(Carbon::now()) : null;

        $oldCurrentWeight = $ternak->current_weight;
        $oldLastWeightDate = $ternak->last_weight_date;
        $newCurrentWeight = $request->input('current_weight');
        $newLastWeightDate = $request->input('last_weight_date');

        $oldLastWeightDateObj = $oldLastWeightDate ? Carbon::parse($oldLastWeightDate) : null;
        
        if ($newCurrentWeight !== $oldCurrentWeight || $newLastWeightDate !== ($oldLastWeightDateObj ? $oldLastWeightDateObj->format('Y-m-d') : null)) {
            $data['last_weight_date'] = $newLastWeightDate ? Carbon::parse($newLastWeightDate) : Carbon::now();
        
            WeightHistory::create([
                'ternak_tag_number' => $ternak->tag_number,
                'weight' => $newCurrentWeight,
                'measurement_date' => $data['last_weight_date'],
            ]);
        }
        
        $ternak->update($data); // Update data ternak utama

        $this->updateTernakUpweight($ternak); // Re-calculate upweight setelah update

        return redirect()->route('ternak.index')->with('success', 'Data ternak berhasil diperbarui!');
    }

    /**
     * Hapus banyak data ternak berdasarkan checkbox terpilih.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkDelete(Request $request)
    {
        // Menerima array tag_number dari input form
        $tagNumbers = $request->input('tag_numbers');

        if (empty($tagNumbers)) {
            return redirect()->route('ternak.index')->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }

        try {
            // Hapus data ternak berdasarkan tag_number
            $deletedCount = Ternak::whereIn('tag_number', $tagNumbers)->delete();

            return redirect()->route('ternak.index')->with('success', "Berhasil menghapus {$deletedCount} data ternak.");
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error during bulk delete:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'tag_numbers_attempted' => $tagNumbers,
            ]);
            return redirect()->route('ternak.index')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
   

    /**
     * Import data Ternak dari file CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $header = array_map('trim', array_map('strtolower', array_shift($data)));

        $expectedHeaders = [
            'tag_number',
            'species_id',
            'kategori_id',
            'sub_kategori_id',
            'tipe_domba_id',
            'jenis_domba_id',
            'gender',
            'date_of_birth',
            'date_of_entry',
            'usia_masuk_dalam_bulan',
            'entry_weight',
            'current_weight',
            'last_weight_date',
            'upweight',
            'kondisi_id',
            'status_id',
            'kandang_id',
            'dam_tag_number',
            'sire_tag_number',
            'notes',
            'photo_path'
        ];

        if (count(array_diff($expectedHeaders, $header)) > 0 || count(array_diff($header, $expectedHeaders)) > 0) {
            throw ValidationException::withMessages([
                'csv_file' => 'Format header CSV tidak sesuai. Harap gunakan: ' . implode(', ', $expectedHeaders),
            ]);
        }

        $importedCount = 0;
        $skippedCount = 0;
        $errors = [];

        foreach ($data as $row) {
            if (empty(array_filter($row, 'strlen'))) {
                continue;
            }

            if (count($row) !== count($header)) {
                $errors[] = "Baris dilewati (jumlah kolom tidak cocok): " . implode(', ', $row);
                $skippedCount++;
                continue;
            }

            $rowData = array_combine($header, $row);
            $rowData = $this->sanitizeRowData($rowData);

            $validator = Validator::make($rowData, [
                'tag_number' => 'required|string|max:255|unique:ternaks,tag_number',
                'species_id' => 'required|integer|exists:species,id',
                'kategori_id' => 'required|integer|exists:kategori,id',
                'sub_kategori_id' => 'nullable|integer|exists:sub_kategori,id',
                'tipe_domba_id' => 'required|integer|exists:tipe_domba,id',
                'jenis_domba_id' => 'required|integer|exists:jenis_domba,id',
                'gender' => 'required|in:Jantan,Betina',
                'date_of_birth' => 'nullable|date',
                'date_of_entry' => 'nullable|date',
                'usia_masuk_dalam_bulan' => 'nullable|integer|min:0',
                'entry_weight' => 'nullable|numeric',
                'current_weight' => 'nullable|numeric',
                'last_weight_date' => 'nullable|date',
                'upweight' => 'nullable|numeric',
                'kondisi_id' => 'required|integer|exists:kondisi,id',
                'status_id' => 'required|integer|exists:status,id',
                'kandang_id' => 'nullable|exists:kandang,kandang_id',
                'dam_tag_number' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if (!is_null($value) && !Ternak::where('tag_number', $value)->exists()) {
                            $fail("Dam tag number '{$value}' tidak ditemukan.");
                        }
                    }
                ],
                'sire_tag_number' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if (!is_null($value) && !Ternak::where('tag_number', $value)->exists()) {
                            $fail("Sire tag number '{$value}' tidak ditemukan.");
                        }
                    }
                ],
                'notes' => 'nullable|string',
                'photo_path' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $errors[] = "Baris dilewati (validasi gagal untuk data: " . implode(',', $row) . ") - Errors: " . implode(', ', $validator->errors()->all());
                $skippedCount++;
                continue;
            }

            try {
                $dataToCreate = [
                    'tag_number' => $rowData['tag_number'],
                    'species_id' => $rowData['species_id'],
                    'kategori_id' => $rowData['kategori_id'],
                    'sub_kategori_id' => $rowData['sub_kategori_id'],
                    'tipe_domba_id' => $rowData['tipe_domba_id'],
                    'jenis_domba_id' => $rowData['jenis_domba_id'],
                    'gender' => $rowData['gender'],
                    'date_of_birth' => $rowData['date_of_birth'],
                    'date_of_entry' => $rowData['date_of_entry'],
                    'usia_masuk_dalam_bulan' => $rowData['usia_masuk_dalam_bulan'],
                    'entry_weight' => $rowData['entry_weight'],
                    'current_weight' => $rowData['current_weight'],
                    'last_weight_date' => $rowData['last_weight_date'],
                    'upweight' => $rowData['upweight'],
                    'kondisi_id' => $rowData['kondisi_id'],
                    'status_id' => $rowData['status_id'],
                    'kandang_id' => $rowData['kandang_id'],
                    'dam_tag_number' => $rowData['dam_tag_number'],
                    'sire_tag_number' => $rowData['sire_tag_number'],
                    'notes' => $rowData['notes'],
                    'photo_path' => $rowData['photo_path'],
                ];

                $dataToCreate['umur_hari'] = $dataToCreate['date_of_birth'] ? Carbon::parse($dataToCreate['date_of_birth'])->diffInDays(Carbon::now()) : null;
                $dataToCreate['hari_di_peternakan'] = $dataToCreate['date_of_entry'] ? Carbon::parse($dataToCreate['date_of_entry'])->diffInDays(Carbon::now()) : null;

                $ternak = Ternak::create($dataToCreate);

                // Setelah ternak dibuat, jika ada current_weight, buat riwayatnya
                if ($ternak && $rowData['current_weight'] !== null) {
                    WeightHistory::create([
                        'ternak_tag_number' => $ternak->tag_number,
                        'weight' => $rowData['current_weight'],
                        'measurement_date' => $rowData['last_weight_date'] ?? Carbon::now(),
                    ]);
                }

                // PENTING: Untuk data import, upweight bisa langsung dari CSV
                // Atau bisa juga di-recalculate setelah semua history import selesai (lebih kompleks)
                // $this->updateTernakUpweight($ternak); // Bisa dipanggil di sini juga jika ingin recalculate dari data yang baru diimport

                $importedCount++;
            } catch (\Exception $e) {
                Log::error("Gagal mengimpor baris CSV: " . $e->getMessage(), ['row_data' => $rowData, 'exception' => $e]);
                $errors[] = "Baris dilewati (kesalahan penyimpanan database): " . implode(',', $row) . " - Error: " . $e->getMessage();
                $skippedCount++;
            }
        }

        $message = "Impor selesai. Berhasil mengimpor {$importedCount} data.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} data dilewati.";
        }

        if (!empty($errors)) {
            return redirect()->route('ternak.index')->with('warning', $message)->withErrors(['import_errors' => $errors]);
        }

        return redirect()->route('ternak.index')->with('success', $message);
    }

    /**
     * Sanitize row data untuk menangani empty string dan konversi tipe data
     *
     * @param array $rowData
     * @return array
     */
    private function sanitizeRowData(array $rowData): array
    {
        $nullableColumns = [
            'sub_kategori_id',
            'date_of_birth',
            'date_of_entry',
            'usia_masuk_dalam_bulan',
            'entry_weight',
            'current_weight',
            'last_weight_date',
            'upweight', 
            'kandang_id',
            'dam_tag_number',
            'sire_tag_number',
            'notes',
            'photo_path'
        ];

        $integerColumns = [
            'species_id',
            'kategori_id',
            'sub_kategori_id',
            'tipe_domba_id',
            'jenis_domba_id',
            'usia_masuk_dalam_bulan',
            'kondisi_id',
            'status_id'
        ];

        $numericColumns = ['entry_weight', 'current_weight', 'upweight']; // <<< TAMBAHKAN INI

        foreach ($rowData as $key => $value) {
            $value = trim($value);

            if (in_array($key, $nullableColumns)) {
                $rowData[$key] = ($value === '' || $value === null) ? null : $value;
            } elseif (in_array($key, $integerColumns) && $value !== '' && $value !== null) {
                $rowData[$key] = (int) $value;
            } elseif (in_array($key, $numericColumns) && $value !== '' && $value !== null) {
                $rowData[$key] = (float) $value;
            } else {
                $rowData[$key] = $value === '' ? null : $value;
            }
        }

        return $rowData;
    }

    // --- METODE BARU UNTUK WEIGHT HISTORY ---

    /**
     * Store a newly created weight history entry for a specific Ternak.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tag_number
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeWeightHistory(Request $request, string $tag_number): \Illuminate\Http\RedirectResponse
    {
        $ternak = Ternak::find($tag_number);

        if (!$ternak) {
            abort(404, 'Data Ternak tidak ditemukan.');
        }

        $request->validate([
            'weight' => 'required|numeric|min:0.01',
            'measurement_date' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Buat entri riwayat bobot baru
            $newHistory = WeightHistory::create([
                'ternak_tag_number' => $tag_number,
                'weight' => $request->weight,
                'measurement_date' => $request->measurement_date,
            ]);

            // Update current_weight dan last_weight_date pada Ternak utama
            // Ini akan memastikan data utama ternak selalu mencerminkan data bobot terakhir
            $ternak->current_weight = $newHistory->weight;
            $ternak->last_weight_date = $newHistory->measurement_date;
            $ternak->save();

            $this->updateTernakUpweight($ternak); // <<< Hitung dan simpan upweight

            DB::commit();
            return redirect()->route('ternak.show', $tag_number)->with('success', 'Riwayat bobot berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal menambah riwayat bobot untuk {$tag_number}: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan riwayat bobot. Silakan coba lagi.');
        }
    }

    /**
     * Update the specified weight history entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWeightHistory(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $history = WeightHistory::find($id);

        if (!$history) {
            abort(404, 'Riwayat Bobot tidak ditemukan.');
        }

        // Validasi dengan error bag kustom untuk modal
        $validator = Validator::make($request->all(), [
            'weight' => 'required|numeric|min:0.01',
            'measurement_date' => 'required|date',
        ], [], [ // Custom attributes, jika diperlukan
            'weight' => 'berat',
            'measurement_date' => 'tanggal pengukuran'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'edit_weight_modal')->withInput($request->all())->with('show_edit_weight_modal', true)->with('error', 'Validasi gagal saat memperbarui riwayat bobot. Silakan periksa data Anda.');
        }

        DB::beginTransaction();
        try {
            $history->update([
                'weight' => $request->weight,
                'measurement_date' => $request->measurement_date,
            ]);

            // Setelah update, re-calculate current_weight dan last_weight_date pada Ternak utama
            $ternak = $history->ternak;
            $latestHistory = $ternak->weightHistories()->orderByDesc('measurement_date')->first();

            // Pastikan data utama ternak selalu mencerminkan data bobot terakhir
            if ($latestHistory) {
                $ternak->current_weight = $latestHistory->weight;
                $ternak->last_weight_date = $latestHistory->measurement_date;
            } else {
                $ternak->current_weight = null;
                $ternak->last_weight_date = null;
            }
            $ternak->save();

            $this->updateTernakUpweight($ternak); // <<< Hitung dan simpan upweight

            DB::commit();
            return redirect()->route('ternak.show', $history->ternak_tag_number)->with('success', 'Riwayat bobot berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal memperbarui riwayat bobot id {$id}: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('show_edit_weight_modal', true)->with('error', 'Terjadi kesalahan saat memperbarui riwayat bobot. Silakan coba lagi.');
        }
    }

    /**
     * Delete the specified weight history entry.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyWeightHistory(int $id): \Illuminate\Http\RedirectResponse
    {
        $history = WeightHistory::find($id);

        if (!$history) {
            abort(404, 'Riwayat Bobot tidak ditemukan.');
        }

        $ternakTagNumber = $history->ternak_tag_number;

        DB::beginTransaction();
        try {
            $history->delete();

            // Setelah dihapus, re-calculate current_weight dan last_weight_date pada Ternak utama
            $ternak = Ternak::find($ternakTagNumber);
            if ($ternak) {
                $latestHistory = $ternak->weightHistories()->orderByDesc('measurement_date')->first();
                if ($latestHistory) {
                    $ternak->current_weight = $latestHistory->weight;
                    $ternak->last_weight_date = $latestHistory->measurement_date;
                } else {
                    $ternak->current_weight = null;
                    $ternak->last_weight_date = null;
                }
                $ternak->save();
                $this->updateTernakUpweight($ternak); // <<< Hitung dan simpan upweight
            }

            DB::commit();
            return redirect()->route('ternak.show', $ternakTagNumber)->with('success', 'Riwayat bobot berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal menghapus riwayat bobot id {$id}: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus riwayat bobot. Silakan coba lagi.');
        }
    }

    /**
     * ---------------------------------------------------
     *  METHOD BARU UNTUK INVESTOR
     * ---------------------------------------------------
     */
    public function myTernak()
    {
        $userId = Auth::id();
        $investor = Investor::where('user_id', $userId)->first();
        $ternaks = [];

        if ($investor) {
            $ternaks = Ternak::where('investor_id', $investor->id)->get();
        }

        return view('investor.ternakku', compact('ternaks'));
    }

}
