@extends('adminlte::page')

@section('title', 'Detail Data Pakan')

@section('content_header')
    <h1>Detail Data Pakan</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Detail Pakan: {{ $pakan->name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->id }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Pakan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipe Pakan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->tipePakan->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Stok</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->stock }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Unit</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->unit }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Harga per Unit</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ number_format($pakan->price_per_unit, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->description ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dibuat Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->created_at }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Diperbarui Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $pakan->updated_at }}</p>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('pakan.edit', $pakan->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('pakan.index') }}" class="btn btn-secondary">Kembali</a>
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
