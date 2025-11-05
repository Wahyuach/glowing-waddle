@extends('adminlte::page')

@section('title', 'Tambah Kandang di Kavling ' . $kavling->no_kavling)

@section('content_header')
    <h1>Tambah Kandang di Kavling {{ $kavling->no_kavling }}</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Kandang</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('kavling.kandang.store', $kavling->no_kavling) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kavling_id">Nomor Kavling</label>
                            <input type="text" class="form-control" id="kavling_id" name="kavling_id" value="{{ $kavling->no_kavling }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kandang_id">ID Kandang</label>
                            <input type="text" class="form-control @error('kandang_id') is-invalid @enderror" id="kandang_id" name="kandang_id" value="{{ old('kandang_id') }}" placeholder="Contoh: K001" required>
                            @error('kandang_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="tipe_kandang_id">Tipe Kandang</label>
                            <select class="form-control @error('tipe_kandang_id') is-invalid @enderror" id="tipe_kandang_id" name="tipe_kandang_id">
                                <option value="">Pilih Tipe Kandang</option>
                                @foreach($tipeKandangs as $tipe)
                                    <option value="{{ $tipe->id }}" {{ old('tipe_kandang_id') == $tipe->id ? 'selected' : '' }}>{{ $tipe->name }}</option>
                                @endforeach
                            </select>
                            @error('tipe_kandang_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="kapasitas">Kapasitas</label>
                            <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}" placeholder="Masukkan Kapasitas Kandang" required min="0">
                            @error('kapasitas')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        {{-- current_population dihapus dari input form karena dihitung otomatis --}}
                        {{-- <div class="form-group">
                            <label for="current_population">Populasi Saat Ini</label>
                            <input type="number" class="form-control" id="current_population" name="current_population" value="{{ old('current_population', 0) }}" placeholder="Masukkan Populasi Saat Ini" required min="0">
                        </div> --}}
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan">{{ old('notes') }}</textarea>
                            @error('notes')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kavling.kandang.index', $kavling->no_kavling) }}" class="btn btn-secondary">Batal</a>
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
