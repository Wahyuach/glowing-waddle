@extends('adminlte::page')

@section('title', 'Daftar Logbook Kejadian')

@section('content_header')
    <h1>Daftar Logbook Kejadian</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catatan Kejadian Ternak</h3>
            <div class="card-tools">
                <a href="{{ route('logbooks.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Log
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>TAGGING</th>
                        <th>Kejadian</th>
                        <th>Kandang Lama</th>
                        <th>Kandang Baru</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logbooks as $log)
                        <tr>
                            <td>{{ $log->tanggal_kejadian->format('d/m/Y H:i') }}</td>
                            <td><a href="#">{{ $log->ternak_tag_number }}</a></td>
                            <td>{{ $log->kejadian }}</td>
                            <td>{{ $log->kandangLama->kandang_id ?? '-' }}</td>
                            <td>{{ $log->kandangBaru->kandang_id ?? '-' }}</td>
                            <td>{{ Str::limit($log->keterangan, 50) }}</td>
                            <td>
                                {{-- Tombol Detail, Edit, Hapus --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada catatan kejadian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $logbooks->links() }}
        </div>
    </div>
@stop