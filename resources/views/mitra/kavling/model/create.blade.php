@extends('adminlte::page')

@section('title', 'Tambah Data Kavling')

@section('content_header')
    <h1>Tambah Data Kavling</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Kavling</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('kavling.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="no_kavling">Nomor Kavling</label>
                            <input type="text" class="form-control @error('no_kavling') is-invalid @enderror" id="no_kavling" name="no_kavling" value="{{ old('no_kavling') }}" placeholder="Masukkan Nomor Kavling" required>
                            @error('no_kavling')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kapasitas">Kapasitas</label>
                            <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}" placeholder="Masukkan Kapasitas Kavling" required min="0">
                            @error('kapasitas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_kepemilikan">Status Kepemilikan</label>
                            <input type="text" class="form-control @error('status_kepemilikan') is-invalid @enderror" id="status_kepemilikan" name="status_kepemilikan" value="{{ old('status_kepemilikan') }}" placeholder="Contoh: Milik Pribadi, Sewa" required>
                            @error('status_kepemilikan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="investor_id">Investor (Opsional)</label>
                            <select class="form-control @error('investor_id') is-invalid @enderror" id="investor_id" name="investor_id">
                                <option value="">Pilih Investor</option>
                                @foreach($investors as $investor)
                                    <option value="{{ $investor->id }}" {{ old('investor_id') == $investor->id ? 'selected' : '' }}>{{ $investor->name }}</option>
                                @endforeach
                            </select>
                            @error('investor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="abk_id">ABK (Opsional)</label>
                            <select class="form-control @error('abk_id') is-invalid @enderror" id="abk_id" name="abk_id">
                                <option value="">Pilih ABK</option>
                                @foreach($abks as $abk)
                                    <option value="{{ $abk->id }}" {{ old('abk_id') == $abk->id ? 'selected' : '' }}>{{ $abk->name }}</option>
                                @endforeach
                            </select>
                            @error('abk_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kavling.index') }}" class="btn btn-secondary">Batal</a>
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
