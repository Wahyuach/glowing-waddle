@extends('adminlte::page')

@section('title', 'Tambah Data Karyawan (ABK)')

@section('content_header')
    <h1>Tambah Data Karyawan (ABK)</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Karyawan</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('abk.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Karyawan" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan Nomor Telepon">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukkan Alamat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="photo_path">Path Foto (Opsional)</label>
                            <input type="text" class="form-control" id="photo_path" name="photo_path" placeholder="Masukkan Path Foto atau URL">
                            {{-- Jika Anda akan mengunggah file, ini perlu diubah menjadi input type="file" dan menambahkan enctype="multipart/form-data" pada form --}}
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
