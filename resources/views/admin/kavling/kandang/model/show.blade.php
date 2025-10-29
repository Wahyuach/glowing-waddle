@extends('adminlte::page')

@section('title', 'Detail Kandang di Kavling ' . $kavling->no_kavling)

@section('content_header')
    <h1>Detail Kandang: {{ $kandang->kandang_id }} di Kavling {{ $kavling->no_kavling }}</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Informasi Kandang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor Kavling</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->no_kavling }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID Kandang</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kandang->kandang_id }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kapasitas</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kandang->kapasitas }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Populasi Saat Ini</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kandang->current_population }}</p> {{-- Ini akan memanggil accessor --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipe Kandang</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kandang->tipeKandang->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Catatan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kandang->notes ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dibuat Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kandang->created_at }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Diperbarui Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kandang->updated_at }}</p>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('kavling.kandang.edit', ['kavling' => $kavling->no_kavling, 'kandang' => $kandang->kandang_id]) }}" class="btn btn-warning">Edit Informasi Kandang</a>
                    <a href="{{ route('kavling.kandang.index', $kavling->no_kavling) }}" class="btn btn-secondary">Kembali ke Daftar Kandang</a>
                </div>
            </div>
            <!-- /.card -->
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
