@extends('adminlte::page')

@section('title', 'Data Investor')

@section('content_header')
    <h1>Data Investor</h1>
@stop

@section('content')
    <p>Kelola data investor Anda di sini.</p>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('investor.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Investor</a>
                        <!-- <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#importCsvModal">
                            <i class="fas fa-file-import mr-1"></i>Import
                        </button>
                        <a href="{{ asset('templates/template_kavlings.xlsx') }}" class="btn btn-success ml-2" download>
                            <i class="fas fa-download mr-1"></i>Template
                        </a> -->
                    </div>
                </div>
                <div class="card-body">
                    {{-- Pesan Status Impor --}}
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
                            Terjadi kesalahan saat impor CSV:
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
                    <form action="{{ route('investor.index') }}" method="GET" class="mb-3">
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
                                    <input type="text" class="form-control" name="search" placeholder="Cari Investor..." value="{{ $search }}">
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
                                    <th>NAMA<i class="fas fa-sort-alt"></i></th>
                                    <th>NO_TELP<i class="fas fa-sort-alt"></i></th>
                                    <th>ALAMAT</th>
                                    <th style="width: 15%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($investors as $investor)
                                    <tr>
                                        <td>{{ $loop->iteration + ($investors->currentPage() - 1) * $investors->perPage() }}</td>
                                        <td>{{ $investor->name }}</td>
                                        <td>{{ $investor->phone_number ?? '-' }}</td>
                                        <td>{{ $investor->address ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm-1" role="group">
                                                <a href="{{ route('investor.show', $investor->id) }}" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('investor.edit', $investor->id) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('investor.destroy', $investor->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Tidak ada data investor.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Menampilkan informasi paginasi --}}
                        <span class="text-muted">Menampilkan {{ $investors->firstItem() }} hingga {{ $investors->lastItem() }} dari {{ $investors->total() }} data</span>
                        {{-- Render pagination links --}}
                        {{ $investors->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Impor CSV --}}
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('investor.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importCsvModalLabel">Impor Data Investor dari CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="csv_file">Pilih File CSV</label>
                            <input type="file" class="form-control-file @error('csv_file') is-invalid @enderror" id="csv_file" name="csv_file" required>
                            <small id="csvFileHelp" class="form-text text-muted">Format kolom: name, phone_number, address</small>
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
        // Menampilkan modal jika ada error validasi impor CSV
        @if($errors->has('csv_file') || $errors->has('import_errors'))
            $(document).ready(function() {
                $('#importCsvModal').modal('show');
            });
        @endif
    </script>
@stop
