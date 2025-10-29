@extends('adminlte::page')

@section('title', 'Edit Data Karyawan (ABK)')

@section('content_header')
    <h1>Edit Data Karyawan (ABK)</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Karyawan: {{ $abk->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('abk.update', $abk->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Gunakan metode PUT untuk pembaruan --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $abk->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $abk->phone_number }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ $abk->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="photo_path">Path Foto (Opsional)</label>
                            <input type="text" class="form-control" id="photo_path" name="photo_path" value="{{ $abk->photo_path }}">
                            {{-- Jika Anda akan mengunggah file, ini perlu diubah menjadi input type="file" --}}
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                        <a href="{{ route('abk.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
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
