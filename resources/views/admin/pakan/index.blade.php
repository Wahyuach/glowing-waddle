@extends('adminlte::page')

@section('title', 'Data Pakan')

@section('content_header')
    <h1>Data Pakan</h1>
@stop

@section('content')
    <p>Kelola data pakan Anda di sini.</p>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('pakan.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Tambah Pakan</a>
                </div>
                <div class="card-body">
                    {{-- Form Pencarian dan Show Entries --}}
                    {{-- Menghapus id="searchForm" karena tidak lagi dibutuhkan oleh JS untuk live search --}}
                    <form action="{{ route('pakan.index') }}" method="GET" class="mb-3">
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
                                    <input type="text" class="form-control" name="search" placeholder="Cari Pakan..." value="{{ $search }}">
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
                                    <th>NAMA<i class="fas fa-sort-alt"></i></th>
                                    <th>TIPE_PAKAN<i class="fas fa-sort-alt"></i></th>
                                    <th>STOK<i class="fas fa-sort-alt"></i></th>
                                    <th>UNIT<i class="fas fa-sort-alt"></i></th>
                                    <th>HARGA/UNIT<i class="fas fa-sort-alt"></i></th>
                                    <th style="width: 15%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pakans as $pakan)
                                    <tr>
                                        <td>{{ $loop->iteration + ($pakans->currentPage() - 1) * $pakans->perPage() }}</td>
                                        <td>{{ $pakan->name }}</td>
                                        <td>{{ $pakan->tipePakan->name ?? '-' }}</td>
                                        <td>{{ $pakan->stock }}</td>
                                        <td>{{ $pakan->unit }}</td>
                                        <td>{{ number_format($pakan->price_per_unit, 2, ',', '.') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm-1" role="group">
                                                <a href="{{ route('pakan.show', $pakan->id) }}" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('pakan.edit', $pakan->id) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('pakan.destroy', $pakan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Tidak ada data pakan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Menampilkan informasi paginasi --}}
                        <span class="text-muted">Menampilkan {{ $pakans->firstItem() }} hingga {{ $pakans->lastItem() }} dari {{ $pakans->total() }} data</span>
                        {{-- Render pagination links --}}
                        {{ $pakans->links('pagination::bootstrap-4') }}
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
        // Auto-submit form when 'show-entries' select box changes
        document.getElementById('show-entries').addEventListener('change', function() {
            this.closest('form').submit();
        });

    </script>
@stop
