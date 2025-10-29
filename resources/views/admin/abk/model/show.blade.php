@extends('adminlte::page')

@section('title', 'Detail Data Karyawan (ABK)')

@section('content_header')
    <h1>Detail Data Karyawan (ABK)</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Detail Karyawan: {{ $abk->name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $abk->id }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $abk->name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $abk->phone_number ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $abk->address ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Path Foto</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $abk->photo_path ?? '-' }}</p>
                            @if($abk->photo_path)
                                <img src="{{ asset($abk->photo_path) }}" alt="Foto Karyawan" class="img-thumbnail mt-2" style="max-width: 200px;">
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dibuat Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $abk->created_at }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Diperbarui Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $abk->updated_at }}</p>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('abk.edit', $abk->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('abk.index') }}" class="btn btn-secondary">Kembali</a>
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
