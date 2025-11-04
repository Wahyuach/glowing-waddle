@extends('adminlte::page')

@section('title', 'Data Karyawan (ABK)')

@section('content_header')
    <h1>Data Karyawan (ABK)</h1>
@stop

@section('content')
    <p>Kelola data karyawan Anda di sini.</p>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('abk.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Karyawan</a>
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
                    <form action="{{ route('abk.index') }}" method="GET" class="mb-3">
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
                                    <input type="text" class="form-control" name="search" placeholder="Cari Karyawan..." value="{{ $search }}">
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
                                    <th style="width: 10%;">FOTO</th>
                                    <th>NAMA<i class="fas fa-sort-alt"></i></th>
                                    <th>NO_TELP<i class="fas fa-sort-alt"></i></th>
                                    <th>ALAMAT</th>
                                    <th style="width: 15%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($abks as $abk)
                                    <tr>
                                        <td>{{ $loop->iteration + ($abks->currentPage() - 1) * $abks->perPage() }}</td>
                                        <td>
                                            @if($abk->photo_path)
                                                <img src="{{ asset($abk->photo_path) }}" alt="Foto" class="img-thumbnail" style="width: 200px; height: 100px; object-fit: cover;">
                                            @else
                                                <i class="fas fa-user-circle fa-2x text-muted"></i>
                                            @endif
                                        </td>
                                        <td>{{ $abk->name }}</td>
                                        <td>{{ $abk->phone_number ?? '-' }}</td>
                                        <td>{{ $abk->address ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm-1" role="group">
                                                <a href="{{ route('abk.show', $abk->id) }}" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('abk.edit', $abk->id) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('abk.destroy', $abk->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Tidak ada data karyawan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Menampilkan informasi paginasi --}}
                        <span class="text-muted">Menampilkan {{ $abks->firstItem() }} hingga {{ $abks->lastItem() }} dari {{ $abks->total() }} data</span>
                        {{-- Render pagination links --}}
                        {{ $abks->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Impor CSV --}}
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('abk.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importCsvModalLabel">Impor Data Karyawan (ABK) dari CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="csv_file">Pilih File CSV</label>
                            <input type="file" class="form-control-file @error('csv_file') is-invalid @enderror" id="csv_file" name="csv_file" required>
                            <small id="csvFileHelp" class="form-text text-muted">Format kolom: name, phone_number, address, photo_path</small>
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
    <!-- <script>
        // Menampilkan modal jika ada error validasi impor CSV
        @if($errors->has('csv_file') || $errors->has('import_errors'))
            $(document).ready(function() {
                $('#importCsvModal').modal('show');
            });
        @endif
    </script> -->
@stop
