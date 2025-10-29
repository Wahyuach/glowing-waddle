@extends('adminlte::page')

@section('title', 'Edit Data Investor')

@section('content_header')
    <h1>Edit Data Investor</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Investor: {{ $investor->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('investor.update', $investor->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Gunakan metode PUT untuk pembaruan --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Investor</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $investor->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $investor->phone_number) }}" placeholder="Masukkan Nomor Telepon">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Masukkan Alamat">{{ old('address', $investor->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                        <a href="{{ route('investor.index') }}" class="btn btn-secondary">Batal</a>
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
