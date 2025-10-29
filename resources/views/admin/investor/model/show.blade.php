@extends('adminlte::page')

@section('title', 'Detail Data Investor')

@section('content_header')
    <h1>Detail Data Investor</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Detail Investor: {{ $investor->name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $investor->id }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $investor->name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $investor->phone_number ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $investor->address ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dibuat Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $investor->created_at }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Diperbarui Pada</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $investor->updated_at }}</p>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('investor.edit', $investor->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('investor.index') }}" class="btn btn-secondary">Kembali</a>
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
