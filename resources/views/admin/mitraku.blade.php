@extends('adminlte::page') {{-- (Atau layout utama kamu) --}}

{{-- Ganti judulnya jadi lebih pas (misal: Dashboard Admin) --}}
@section('title', 'Dashboard Admin') 

@section('content_header')
    {{-- Ganti juga header-nya --}}
    <h1>Dashboard Admin</h1> 
@stop

@section('content')
    <div class="row">
        
        {{-- BAGIAN KANAN: DAFTAR MITRA (BARU) --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Mitra (User Mitra)</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Mitra</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Kita looping variabel $usersMitra baru dari controller --}}
                            @forelse ($usersMitra as $mitra)
                                <tr>
                                    <td>{{ $mitra->name }}</td>
                                    <td>{{ $mitra->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">
                                        Belum ada data user mitra.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop