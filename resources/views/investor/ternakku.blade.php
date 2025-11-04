@extends('adminlte::page') {{-- (Atau layout utama kamu) --}}

@section('title', 'Ternak Saya')

@section('content_header')
    <h1>Ternak Saya</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Ternak</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tag Number</th>
                        <th>Kandang</th>
                        <th>Jenis Domba</th>
                        <th>Bobot Terkini (Kg)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ternaks as $index => $ternak)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{-- Kita asumsikan investor boleh klik lihat detail --}}
                                <a href="{{ route('ternak.show', $ternak->tag_number) }}">
                                    {{ $ternak->tag_number }}
                                </a>
                            </td>
                            {{-- (Relasi ini mungkin perlu '?' jika datanya boleh null) --}}
                            <td>{{ $ternak->kandang->kandang_id ?? '-' }}</td>
                            <td>{{ $ternak->jenisDomba->name ?? '-' }}</td>
                            <td>{{ $ternak->current_weight ?? '-' }}</td>
                            <td>{{ $ternak->status->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Anda belum memiliki data ternak.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
