@extends('adminlte::page')

@section('title', 'Edit Data Pakan')

@section('content_header')
    <h1>Edit Data Pakan</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Pakan: {{ $pakan->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('pakan.update', $pakan->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Gunakan metode PUT untuk pembaruan --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Pakan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $pakan->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tipe_pakan_id">Tipe Pakan</label>
                            <select class="form-control @error('tipe_pakan_id') is-invalid @enderror" id="tipe_pakan_id" name="tipe_pakan_id">
                                <option value="">Pilih Tipe Pakan</option>
                                @foreach($tipePakans as $tipe)
                                    <option value="{{ $tipe->id }}" {{ old('tipe_pakan_id', $pakan->tipe_pakan_id) == $tipe->id ? 'selected' : '' }}>{{ $tipe->name }}</option>
                                @endforeach
                            </select>
                            @error('tipe_pakan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $pakan->stock) }}" required min="0">
                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit', $pakan->unit) }}" required>
                            @error('unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price_per_unit">Harga per Unit</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_unit') is-invalid @enderror" id="price_per_unit" name="price_per_unit" value="{{ old('price_per_unit', $pakan->price_per_unit) }}" required min="0">
                            @error('price_per_unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $pakan->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                        <a href="{{ route('pakan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </section>
@stop

@section('css')
    {{-- Tambahkan stylesheet tambahan di sini --}}
@stop

@section('js')
    <script>

    </script>
@stop
