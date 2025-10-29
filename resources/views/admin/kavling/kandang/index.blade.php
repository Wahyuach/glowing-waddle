@extends('adminlte::page')

@section('title', 'Daftar Kandang di Kavling ' . $kavling->no_kavling)

@section('content_header')
    <h1>Daftar Kandang di Kavling {{ $kavling->no_kavling }}</h1>
@stop

@section('content')
    <p>Kelola kandang di kavling ini.</p>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-end align-items-center">
                    <a href="{{ route('kavling.kandang.create', $kavling->no_kavling) }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Tambah Kandang</a>
                </div>
                <div class="card-body">
                    {{-- Form Pencarian dan Show Entries --}}
                    {{-- Menghapus id="searchForm" karena tidak lagi dibutuhkan oleh JS untuk live search --}}
                    <form action="{{ route('kavling.kandang.index', $kavling->no_kavling) }}" method="GET" class="mb-3">
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
                                    {{-- Menghapus id="searchInput" karena tidak lagi digunakan oleh JS untuk live search --}}
                                    <input type="text" class="form-control" name="search" placeholder="Cari Kandang..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        {{-- Mengubah type="button" kembali menjadi type="submit" dan menghapus id="searchButton" --}}
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
                                    <th>ID_KANDANG<i class="fas fa-sort-alt"></i></th>
                                    <th>KAPASITAS<i class="fas fa-sort-alt"></i></th>
                                    <th>POPULASI<i class="fas fa-sort-alt"></i></th> {{-- Diubah --}}
                                    <th>TIPE_KANDANG<i class="fas fa-sort-alt"></i></th>
                                    <th style="width: 15%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kandangs as $kandang)
                                    <tr>
                                        <td>{{ $loop->iteration + ($kandangs->currentPage() - 1) * $kandangs->perPage() }}</td>
                                        <td>{{ $kandang->kandang_id }}</td>
                                        <td>{{ $kandang->kapasitas }}</td>
                                        <td>{{ $kandang->current_population }}</td> {{-- Ini akan memanggil accessor --}}
                                        <td>{{ $kandang->tipeKandang->name ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm-1" role="group">
                                                <a href="{{ route('kavling.kandang.show', ['kavling' => $kavling->no_kavling, 'kandang' => $kandang->kandang_id]) }}" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('kavling.kandang.edit', ['kavling' => $kavling->no_kavling, 'kandang' => $kandang->kandang_id]) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('kavling.kandang.destroy', ['kavling' => $kavling->no_kavling, 'kandang' => $kandang->kandang_id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Tidak ada data kandang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Menampilkan {{ $kandangs->firstItem() }} hingga {{ $kandangs->lastItem() }} dari {{ $kandangs->total() }} data</span>
                        {{ $kandangs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script>
    </script>
@stop
