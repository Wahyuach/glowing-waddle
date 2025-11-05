@extends('adminlte::page')

@section('title', 'Tambah Data Pakan')

@section('content_header')
    <h1>Tambah Data Pakan</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Pakan</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('pakan.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Pakan</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Pakan" required>
                        </div>
                        <div class="form-group">
                            <label for="tipe_pakan_id">Tipe Pakan</label>
                            <select class="form-control" id="tipe_pakan_id" name="tipe_pakan_id">
                                <option value="">Pilih Tipe Pakan</option>
                                @foreach($tipePakans as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Masukkan Jumlah Stok" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" placeholder="Contoh: Kg, Liter, Karung" required>
                        </div>
                        <div class="form-group">
                            <label for="price_per_unit">Harga per Unit</label>
                            <input type="number" step="0.01" class="form-control" id="price_per_unit" name="price_per_unit" placeholder="Masukkan Harga per Unit" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan Deskripsi Pakan"></textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('pakan.index') }}" class="btn btn-secondary">Batal</a>
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
