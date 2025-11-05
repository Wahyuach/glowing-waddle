@extends('adminlte::page')

@section('title', 'Tambah Logbook Kejadian')

@section('content_header')
    <h1>Tambah Logbook Kejadian</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Form dasar --}}
            <form action="{{ route('logbooks.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal_kejadian">Tanggal Kejadian</label>
                            <input type="date" name="tanggal_kejadian" class="form-control @error('tanggal_kejadian') is-invalid @enderror" value="{{ old('tanggal_kejadian', now()->format('Y-m-d')) }}">
                             @error('tanggal_kejadian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ternak_tag_number">TAGGING (C)</label>
                            {{-- Dropdown ini diisi data $ternaks dari Controller --}}
                            <select id="ternak_tag_number" name="ternak_tag_number" class="form-control select2 @error('ternak_tag_number') is-invalid @enderror">
                                <option value="">Pilih Ternak</option>
                                {{-- @foreach($ternaks as $ternak) --}}
                            </select>
                             @error('ternak_tag_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kejadian">Kejadian (H)</label>
                            <select id="select_kejadian" name="kejadian" class="form-control @error('kejadian') is-invalid @enderror">
                                <option value="">Pilih Jenis Kejadian</option>
                                {{-- @foreach($kejadianList as $kejadian) --}}
                            </select>
                             @error('kejadian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    {{-- Sisanya kolom umum (Jenis Ternak, Sex, ABK, Tag Baru) --}}
                    
                </div>
                
                <hr>

                {{-- KOLOM DINAMIS (K - AG) --}}
                @include('admin.logbooks.model._form_detail')
                
                {{-- KETERANGAN (AA) --}}
                <div class="form-group">
                    <label for="keterangan">Keterangan (AA)</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Logbook</button>
            </form>
        </div>
    </div>
@stop

{{-- SCRIPT DINAMIS --}}
@section('js')
<script>
    $(document).ready(function() {
        $('#select_kejadian').change(function() {
            var selectedKejadian = $(this).val();

            // Sembunyikan semua blok detail
            $('#form-kelahiran').hide();
            $('#form-penanganan').hide();
            $('#form-pindah-kandang').hide();
            
            // Tampilkan blok sesuai pilihan
            if (selectedKejadian === 'Melahirkan') {
                $('#form-kelahiran').show();
            } else if (selectedKejadian === 'Pindah Kandang') {
                $('#form-pindah-kandang').show();
            } else if (selectedKejadian === 'Sakit' || selectedKejadian === 'Mati' || selectedKejadian === 'Kastrasi') {
                $('#form-penanganan').show();
            }
            // Kamu bisa tambahkan kondisi lain di sini (misal untuk inseminasi buatan)
        });
    });
</script>
@stop