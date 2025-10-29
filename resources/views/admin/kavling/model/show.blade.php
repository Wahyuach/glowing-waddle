@extends('adminlte::page')

@section('title', 'Detail Data Kavling')

@section('content_header')
    <h1>Detail Data Kavling: {{ $kavling->no_kavling }}</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Informasi Kavling</h3>
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
                        <label class="col-sm-3 col-form-label">Kapasitas</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->kapasitas }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Populasi Saat Ini</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->jumlah_populasi_kandang }}</p> {{-- Ini akan memanggil accessor --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status Kepemilikan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->status_kepemilikan }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Investor</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->investor->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ABK</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->abk->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dibuat Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->created_at }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Diperbarui Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $kavling->updated_at }}</p>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('kavling.edit', $kavling->no_kavling) }}" class="btn btn-warning">Edit Informasi Kavling</a>
                    <a href="{{ route('kavling.index') }}" class="btn btn-secondary">Kembali ke Daftar Kavling</a>
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
