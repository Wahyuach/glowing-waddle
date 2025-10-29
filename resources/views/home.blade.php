@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    {{-- Small Boxes --}}
    <div class="row">
        {{-- Box untuk Data Ternak --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalTernak }}</h3>
                    <p>Total Ternak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-paw"></i>
                </div>
                <a href="{{ route('ternak.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{-- /.col --}}

        {{-- Box untuk Data Kavling --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalKavling }}</h3>
                    <p>Total Kavling</p>
                </div>
                <div class="icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <a href="{{ route('kavling.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{-- /.col --}}

                {{-- Box untuk Data Kavling --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalKandang }}</h3>
                    <p>Total Kandang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
                <a href="{{ route('kavling.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{-- /.col --}}

        {{-- Box untuk Data Pakan --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalPakan }}</h3>
                    <p>Total Pakan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <a href="{{ route('pakan.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{-- /.col --}}

        {{-- Box untuk Data Investor --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalInvestor }}</h3>
                    <p>Total Investor</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <a href="{{ route('investor.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{-- /.col --}}

        {{-- Box untuk Data Karyawan (ABK) --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalAbk }}</h3>
                    <p>Total Karyawan (ABK)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-people-carry"></i>
                </div>
                <a href="{{ route('abk.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{-- /.col --}}
    </div>

@stop

@section('css')
    {{-- Tambahkan stylesheet tambahan di sini --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, saya menggunakan paket Laravel-AdminLTE!"); </script>
    {{-- Script Chart.js dan inisialisasi grafik telah dihapus dari sini --}}
@stop