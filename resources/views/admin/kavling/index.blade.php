@extends('adminlte::page')

@section('title', 'Data Kavling')

@section('content_header')
    <h1>Data Kavling</h1>
@stop

@section('content')
    <p>Kelola data kavling Anda di sini.</p>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('kavling.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Kavling
                        </a>
                        <!-- <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#importCsvModal">
                            <i class="fas fa-file-import mr-1"></i>Import
                        </button>
                        {{-- TAMBAHKAN: Tombol download template --}}
                        <a href="{{ asset('templates/template_kavlings.xlsx') }}" class="btn btn-success ml-2" download>
                            <i class="fas fa-download mr-1"></i>Template
                        </a> -->
                    </div>
                </div>
                <div class="card-body">
                    {{-- Pesan Status Impor (jika ada) --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->has('csv_file') || $errors->has('import_errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="icon fas fa-ban"></i> Impor Gagal!</h5>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Form Pencarian dan Show Entries --}}
                    <form action="{{ route('kavling.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="show-entries" class="d-inline-block align-middle">Menampilkan</label>
                                <select id="show-entries" name="show_entries" class="form-control form-control-sm d-inline-block" style="width: auto;">
                                    <option value="10" {{ $showEntries == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $showEntries == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $showEntries == 50 ? 'selected' : '' }}>50</option>
                                </select>
                                <span class="d-inline-block align-middle">hasil</span>
                            </div>
                            <div class="col-md-4 ml-auto">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="search" placeholder="Cari Kavling..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th style="width: 1%;">NO</th>
                                    <th>NO_KAVLING</th>
                                    <th>KAPASITAS</th>
                                    <th>POPULASI</th>
                                    <th>STATUS_KEPEMILIKAN</th>
                                    <th>INVESTOR</th>
                                    <th>ABK</th>
                                    <th style="width: 20%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kavlings as $kavling)
                                    <tr>
                                        <td>{{ $loop->iteration + ($kavlings->currentPage() - 1) * $kavlings->perPage() }}</td>
                                        <td>{{ $kavling->no_kavling }}</td>
                                        <td>{{ $kavling->kapasitas }}</td>
                                        <td>{{ $kavling->jumlah_populasi_kandang }}</td>
                                        <td>{{ $kavling->status_kepemilikan }}</td>
                                        <td>{{ $kavling->investor->name ?? '-' }}</td>
                                        <td>{{ $kavling->abk->name ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm-1" role="group">
                                                <a href="{{ route('kavling.kandang.index', $kavling->no_kavling) }}" class="btn btn-primary" title="Lihat Kandang"><i class="fas fa-warehouse"></i></a>
                                                <a href="{{ route('kavling.show', $kavling->no_kavling) }}" class="btn btn-info" title="Lihat Detail Kavling"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('kavling.edit', $kavling->no_kavling) }}" class="btn btn-warning" title="Edit Kavling"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('kavling.destroy', $kavling->no_kavling) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Hapus Kavling" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">Tidak ada data kavling.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Menampilkan {{ $kavlings->firstItem() }} hingga {{ $kavlings->lastItem() }} dari {{ $kavlings->total() }} data</span>
                        {{ $kavlings->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Impor CSV --}}
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('kavling.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importCsvModalLabel">Impor Data Kavling dari CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="csv_file">Pilih File CSV</label>
                            <input type="file" class="form-control-file @error('csv_file') is-invalid @enderror" id="csv_file" name="csv_file" required>
                            <small id="csvFileHelp" class="form-text text-muted">
                                Format kolom yang diharapkan: `no_kavling, kapasitas, status_kepemilikan, investor_id, abk_id`
                                <br><br>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #eee; padding: 10px; background-color: #f9f9f9;">
                                    {{-- TAMBAHKAN: Daftar ID yang tersedia untuk dropdown `investor_id` --}}
                                    <strong>investor_id:</strong><br>
                                    @forelse($investors as $investor)
                                        {{ $investor->id }}: {{ $investor->name }}<br>
                                    @empty
                                        Tidak ada data investor.<br>
                                    @endforelse
                                    <br>
                                    {{-- TAMBAHKAN: Daftar ID yang tersedia untuk dropdown `abk_id` --}}
                                    <strong>abk_id:</strong><br>
                                    @forelse($abks as $abk)
                                        {{ $abk->id }}: {{ $abk->name }}<br>
                                    @empty
                                        Tidak ada data ABK.<br>
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
        console.log("Halaman Data Kavling!");

        document.getElementById('show-entries').addEventListener('change', function() {
            this.closest('form').submit();
        });

        // Menampilkan modal jika ada error validasi impor CSV
        @if($errors->has('csv_file') || $errors->has('import_errors'))
            $(document).ready(function() {
                $('#importCsvModal').modal('show');
            });
        @endif
    </script>
@stop