@extends('adminlte::page')

@section('title', 'Data Ternak')

@section('content_header')
    <h1>Data Ternak</h1>
@stop

@section('content')
    <p>Kelola data ternak Anda di sini.</p>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('ternak.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Ternak
                        </a>
                        <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#importCsvModal">
                            <i class="fas fa-file-import mr-1"></i>Import
                        </button>
                        <a href="{{ asset('templates/template_ternaks.csv') }}" class="btn btn-success ml-2" download>
                            <i class="fas fa-download mr-1"></i>Template
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Alert Success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Alert Warning (untuk import) --}}
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Alert Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Error messages for import --}}
                    @if($errors->has('csv_file') || $errors->has('import_errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="icon fas fa-ban"></i> Impor Gagal!</h5>
                            <ul>
                                @foreach($errors->get('csv_file') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                @foreach($errors->get('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Form pencarian dan filter dropdown --}}
                    <form id="filterForm" action="{{ route('ternak.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Menampilkan</label>
                                <select name="show_entries" class="form-control form-control-sm">
                                    <option value="10" {{ $showEntries == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $showEntries == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $showEntries == 50 ? 'selected' : '' }}>50</option>
                                    <option value="all" {{ $showEntries == 'all' ? 'selected' : '' }}>Semua</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Spesies</label>
                                <select name="filter_species" class="form-control form-control-sm">
                                    <option value="">-- Semua Spesies --</option>
                                    @foreach($speciesFilterList as $species)
                                        <option value="{{ $species->id }}" {{ $filterSpecies == $species->id ? 'selected' : '' }}>{{ $species->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Kategori</label>
                                <select name="filter_kategori" class="form-control form-control-sm">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach($kategoriFilterList as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $filterKategori == $kategori->id ? 'selected' : '' }}>{{ $kategori->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Jenis Kelamin</label>
                                <select name="filter_gender" class="form-control form-control-sm">
                                    <option value="">-- Semua --</option>
                                    <option value="Jantan" {{ $filterGender == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                                    <option value="Betina" {{ $filterGender == 'Betina' ? 'selected' : '' }}>Betina</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Kandang</label>
                                <select name="filter_kandang" class="form-control form-control-sm">
                                    <option value="">-- Semua Kandang --</option>
                                    @foreach($kandangFilterList as $kandang)
                                        <option value="{{ $kandang->kandang_id }}" {{ $filterKandang == $kandang->kandang_id ? 'selected' : '' }}>{{ $kandang->kandang_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label>Tipe Domba</label>
                                <select name="filter_tipe_domba" class="form-control form-control-sm">
                                    <option value="">-- Semua Tipe --</option>
                                    @foreach($tipeDombaFilterList as $tipeDomba)
                                        <option value="{{ $tipeDomba->id }}" {{ $filterTipeDomba == $tipeDomba->id ? 'selected' : '' }}>{{ $tipeDomba->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Jenis Domba</label>
                                <select name="filter_jenis_domba" class="form-control form-control-sm">
                                    <option value="">-- Semua Jenis --</option>
                                    @foreach($jenisDombaFilterList as $jenisDomba)
                                        <option value="{{ $jenisDomba->id }}" {{ $filterJenisDomba == $jenisDomba->id ? 'selected' : '' }}>{{ $jenisDomba->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Kondisi</label>
                                <select name="filter_kondisi" class="form-control form-control-sm">
                                    <option value="">-- Semua Kondisi --</option>
                                    @foreach($kondisiFilterList as $kondisi)
                                        <option value="{{ $kondisi->id }}" {{ $filterKondisi == $kondisi->id ? 'selected' : '' }}>{{ $kondisi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="filter_status" class="form-control form-control-sm">
                                    <option value="">-- Semua Status --</option>
                                    @foreach($statusFilterList as $status)
                                        <option value="{{ $status->id }}" {{ $filterStatus == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Baris baru untuk filter 'Terakhir Diukur' (rentang tanggal) dan Search --}}
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="filter_last_measured_date_start">Terakhir Diukur (Mulai)</label>
                                <input type="date" name="filter_last_measured_date_start" id="filter_last_measured_date_start" class="form-control form-control-sm" value="{{ $filterLastMeasuredDateStart ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="filter_last_measured_date_end">Terakhir Diukur (Akhir)</label>
                                <input type="date" name="filter_last_measured_date_end" id="filter_last_measured_date_end" class="form-control form-control-sm" value="{{ $filterLastMeasuredDateEnd ?? '' }}">
                            </div>
                            <div class="col-md-4 ml-auto">
                                <label>Cari</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" placeholder="Cari Ternak..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter mr-1"></i>Terapkan Filter</button>
                                <a href="{{ route('ternak.index') }}" class="btn btn-secondary" id="resetFilterButton"><i class="fas fa-sync-alt mr-1"></i>Reset Filter</a>
                            </div>
                        </div>
                    </form>

                    {{-- FORM BULK DELETE --}}
                    <form action="{{ route('ternak.bulkDelete') }}" method="POST" id="bulkDeleteForm">
                        @csrf
                        @method('DELETE')

                        <div class="mb-2">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data terpilih?')">
                                <i class="fas fa-trash-alt"></i> Hapus Data Terpilih
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <!-- <th>NO</th> -->
                                        <th>TAGGING</th>
                                        <th>FOTO</th>
                                        <th>KATEGORI</th>
                                        <th>JENIS_KELAMIN</th>
                                        <th>KANDANG</th>
                                        <th>UMUR</th>
                                        <th>STATUS</th>
                                        <th>BERAT TERKINI</th>
                                        <th>TERAKHIR DIUKUR</th>
                                        <th>UPWEIGHT</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ternaks as $ternak)
                                        <tr>
                                            <td><input type="checkbox" name="tag_numbers[]" value="{{ $ternak->tag_number }}"></td>
                                            <!-- <td>
                                                @if($ternaks instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                                    {{ $loop->iteration + ($ternaks->firstItem() - 1) }}
                                                @else
                                                    {{ $loop->iteration }}
                                                @endif
                                            </td> -->
                                            <td>{{ $ternak->tag_number }}</td>
                                            <td>
                                                @if($ternak->photo_path)
                                                    <img src="{{ asset($ternak->photo_path) }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <i class="fas fa-image text-muted" style="font-size: 2.5em;"></i>
                                                @endif
                                            </td>
                                            <td>{{ $ternak->kategori->name ?? '-' }}</td>
                                            <td>{{ $ternak->gender }}</td>
                                            <td>{{ $ternak->kandang->kandang_id ?? '-' }}</td>
                                            <td>{{ $ternak->umur_hari ?? '-' }} hari</td>
                                            <td>{{ $ternak->status->name ?? '-' }}</td>
                                            <td>{{ $ternak->current_weight ?? '-' }} kg</td>
                                            <td>{{ $ternak->last_weight_date ? \Carbon\Carbon::parse($ternak->last_weight_date)->format('d-m-Y') : '-' }}</td>
                                            <td>{{ $ternak->upweight ?? '-' }} kg</td>
                                            <td>
                                                <div class="btn-group btn-group-sm-1">
                                                    <a href="{{ route('ternak.show', $ternak->tag_number) }}" class="btn btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('ternak.edit', $ternak->tag_number) }}" class="btn btn-warning" title="Edit Data"><i class="fas fa-edit"></i></a>
                                                    {{-- <form action="{{ route('ternak.destroy', $ternak->tag_number) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus data ini?')"><i class="fas fa-trash"></i></button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="16">Tidak ada data ternak.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            @if($ternaks instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <span class="text-muted">Menampilkan {{ $ternaks->firstItem() }} - {{ $ternaks->lastItem() }} dari {{ $ternaks->total() }} data</span>
                                {{ $ternaks->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                            @else
                                <span class="text-muted">Menampilkan semua {{ $ternaks->count() }} data</span>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    {{-- Modal Impor CSV --}}
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('ternak.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importCsvModalLabel">Impor Data Ternak dari CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="csv_file">Pilih File CSV</label>
                            <input type="file" class="form-control-file @error('csv_file') is-invalid @enderror" id="csv_file" name="csv_file" required>
                            <small id="csvFileHelp" class="form-text text-muted">
                                Format kolom yang diharapkan: `tag_number, species_id, kategori_id, sub_kategori_id, tipe_domba_id, jenis_domba_id, gender, date_of_birth, date_of_entry, usia_masuk_dalam_bulan, entry_weight, current_weight, last_weight_date, upweight, kondisi_id, status_id, kandang_id, dam_tag_number, sire_tag_number, notes, photo_path`
                                <br><br>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #eee; padding: 10px; background-color: #f9f9f9;">
                                    <strong>Contoh ID yang Tersedia:</strong><br>
                                    <strong>species_id:</strong><br>
                                    @forelse($speciesList as $species)
                                        {{ $species->id }}: {{ $species->name }}<br>
                                    @empty
                                        Tidak ada data spesies.<br>
                                    @endforelse
                                    <br>
                                    <strong>kategori_id:</strong><br>
                                    @forelse($kategoriList as $kategori)
                                        {{ $kategori->id }}: {{ $kategori->name }}<br>
                                    @empty
                                        Tidak ada data kategori.<br>
                                    @endforelse
                                    <br>
                                    <strong>sub_kategori_id:</strong><br>
                                    @forelse($subKategoriList as $subKategori)
                                        {{ $subKategori->id }}: {{ $subKategori->name }}<br>
                                    @empty
                                        Tidak ada data kategori.<br>
                                    @endforelse
                                    <br>
                                    <strong>tipe_domba_id:</strong><br>
                                    @forelse($tipeDombaList as $tipeDomba)
                                        {{ $tipeDomba->id }}: {{ $tipeDomba->name }}<br>
                                    @empty
                                        Tidak ada data tipe domba.<br>
                                    @endforelse
                                    <br>
                                    <strong>jenis_domba_id:</strong><br>
                                    @forelse($jenisDombaList as $jenisDomba)
                                        {{ $jenisDomba->id }}: {{ $jenisDomba->name }}<br>
                                    @empty
                                        Tidak ada data jenis domba.<br>
                                    @endforelse
                                    <br>
                                    <strong>kondisi_id:</strong><br>
                                    @forelse($kondisiList as $kondisi)
                                        {{ $kondisi->id }}: {{ $kondisi->name }}<br>
                                    @empty
                                        Tidak ada data kondisi.<br>
                                    @endforelse
                                    <br>
                                    <strong>status_id:</strong><br>
                                    @forelse($statusList as $status)
                                        {{ $status->id }}: {{ $status->name }}<br>
                                    @empty
                                        Tidak ada data status.<br>
                                    @endforelse
                                    <br>
                                    <strong>kandang_id:</strong><br>
                                    @forelse($kandangList as $kandang)
                                        {{ $kandang->kandang_id }}<br>
                                    @empty
                                        Tidak ada data kandang.<br>
                                    @endforelse
                                </div>
                            </small>
                            @error('csv_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Impor Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('input[name="tag_numbers\\[\\]"]').forEach(cb => cb.checked = checked);
        });

        // Function to save filter values to localStorage
        function saveFilters() {
            const form = document.getElementById('filterForm');
            const elements = form.elements;
            let filters = {};
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                if (element.name && (element.tagName === 'SELECT' || element.tagName === 'INPUT')) {
                    filters[element.name] = element.value;
                }
            }
            localStorage.setItem('ternakFilters', JSON.stringify(filters));
        }

        // Function to load filter values from localStorage
        function loadFilters() {
            const savedFilters = localStorage.getItem('ternakFilters');
            if (savedFilters) {
                const filters = JSON.parse(savedFilters);
                const form = document.getElementById('filterForm');
                for (const name in filters) {
                    const element = form.elements[name];
                    if (element) {
                        element.value = filters[name];
                    }
                }
            }
        }

        // Event listener for form submission to save filters
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            saveFilters();
        });

        // Event listener for reset button to clear filters
        document.getElementById('resetFilterButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            localStorage.removeItem('ternakFilters'); // Clear saved filters
            window.location.href = "{{ route('ternak.index') }}"; // Redirect to clear server-side filters
        });

        // Load filters when the page is ready
        $(document).ready(function() {
            loadFilters();

            // Tampilkan modal impor jika ada error validasi terkait impor
            var hasImportErrors = json_encode($errors->has('csv_file') || $errors->has('import_errors'));
            if (hasImportErrors) {
                $('#importCsvModal').modal('show');
            }
        });
    </script>
@stop
