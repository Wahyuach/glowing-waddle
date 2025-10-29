@extends('adminlte::page')

@section('title', 'Tambah Data Ternak')

@section('content_header')
    <h1>Tambah Data Ternak</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Ternak</h3>
                </div>
                <form action="{{ route('ternak.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tag_number">TAG NUMBER</label>
                            <input type="text" class="form-control @error('tag_number') is-invalid @enderror" id="tag_number" name="tag_number" value="{{ old('tag_number') }}" placeholder="Masukkan Nomor Tag" required>
                            @error('tag_number')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="species_id">Spesies</label>
                            <select class="form-control @error('species_id') is-invalid @enderror" id="species_id" name="species_id">
                                <option value="">Pilih Spesies</option>
                                @foreach($species as $sp)
                                    <option value="{{ $sp->id }}" {{ old('species_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                                @endforeach
                            </select>
                            @error('species_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->name }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="sub_kategori_id">Sub Kategori (Opsional)</label>
                            <select class="form-control @error('sub_kategori_id') is-invalid @enderror" id="sub_kategori_id" name="sub_kategori_id">
                                <option value="">Pilih Sub Kategori</option>
                                @foreach($subKategoris as $sub)
                                    <option value="{{ $sub->id }}" {{ old('sub_kategori_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                @endforeach
                            </select>
                            @error('sub_kategori_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="tipe_domba_id">Tipe Domba</label>
                            <select class="form-control @error('tipe_domba_id') is-invalid @enderror" id="tipe_domba_id" name="tipe_domba_id">
                                <option value="">Pilih Tipe Domba</option>
                                @foreach($tipeDombas as $tipeDomba)
                                    <option value="{{ $tipeDomba->id }}" {{ old('tipe_domba_id') == $tipeDomba->id ? 'selected' : '' }}>{{ $tipeDomba->name }}</option>
                                @endforeach
                            </select>
                            @error('tipe_domba_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_domba_id">Jenis Domba</label>
                            <select class="form-control @error('jenis_domba_id') is-invalid @enderror" id="jenis_domba_id" name="jenis_domba_id">
                                <option value="">Pilih Jenis Domba</option>
                                @foreach($jenisDombas as $jenisDomba)
                                    <option value="{{ $jenisDomba->id }}" {{ old('jenis_domba_id') == $jenisDomba->id ? 'selected' : '' }}>{{ $jenisDomba->name }}</option>
                                @endforeach
                            </select>
                            @error('jenis_domba_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin</label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Jantan" {{ old('gender') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                                <option value="Betina" {{ old('gender') == 'Betina' ? 'selected' : '' }}>Betina</option>
                            </select>
                            @error('gender')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="kandang_id">Kandang</label>
                            <select class="form-control @error('kandang_id') is-invalid @enderror" id="kandang_id" name="kandang_id">
                                <option value="">Pilih Kandang</option>
                                @foreach($kandangs as $kandang)
                                    <option value="{{ $kandang->kandang_id }}" {{ old('kandang_id') == $kandang->kandang_id ? 'selected' : '' }}>{{ $kandang->kandang_id }}</option>
                                @endforeach
                            </select>
                            @error('kandang_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="date_of_entry">Tanggal Masuk</label>
                            <input type="date" class="form-control @error('date_of_entry') is-invalid @enderror" id="date_of_entry" name="date_of_entry" value="{{ old('date_of_entry') }}">
                            @error('date_of_entry')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="usia_masuk_dalam_bulan">Usia Masuk (Bulan)</label>
                            <input type="number" class="form-control @error('usia_masuk_dalam_bulan') is-invalid @enderror" id="usia_masuk_dalam_bulan" name="usia_masuk_dalam_bulan" value="{{ old('usia_masuk_dalam_bulan') }}" placeholder="Masukkan Usia Masuk dalam Bulan" min="0">
                            @error('usia_masuk_dalam_bulan')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="kondisi_id">Kondisi</label>
                            <select class="form-control @error('kondisi_id') is-invalid @enderror" id="kondisi_id" name="kondisi_id">
                                <option value="">Pilih Kondisi</option>
                                @foreach($kondisis as $kondisi)
                                    <option value="{{ $kondisi->id }}" {{ old('kondisi_id') == $kondisi->id ? 'selected' : '' }}>{{ $kondisi->name }}</option>
                                @endforeach
                            </select>
                            @error('kondisi_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="entry_weight">Berat Masuk (kg)</label>
                            <input type="number" step="0.01" class="form-control @error('entry_weight') is-invalid @enderror" id="entry_weight" name="entry_weight" value="{{ old('entry_weight') }}" placeholder="Masukkan Berat Masuk">
                            @error('entry_weight')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="current_weight">Berat Saat Ini (kg)</label>
                            <input type="number" step="0.01" class="form-control @error('current_weight') is-invalid @enderror" id="current_weight" name="current_weight" value="{{ old('current_weight') }}" placeholder="Masukkan Berat Saat Ini">
                            @error('current_weight')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="last_weight_date">Tanggal Pengukuran Terakhir (Opsional, jika berat saat ini diisi)</label>
                            <input type="date" class="form-control @error('last_weight_date') is-invalid @enderror" id="last_weight_date" name="last_weight_date" value="{{ old('last_weight_date') }}">
                            @error('last_weight_date')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="upweight">Upweight (kg)</label> {{-- <<< TAMBAHKAN INI (HANYA DISPLAY) --}}
                            <input type="number" step="0.01" class="form-control" id="upweight" name="upweight" value="" readonly placeholder="Akan dihitung otomatis">
                        </div>
                        <div class="form-group">
                            <label for="status_id">Status</label>
                            <select class="form-control @error('status_id') is-invalid @enderror" id="status_id" name="status_id">
                                <option value="">Pilih Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="dam_tag_number">Induk Betina (Tag Number)</label>
                            <select class="form-control @error('dam_tag_number') is-invalid @enderror" id="dam_tag_number" name="dam_tag_number">
                                <option value="">Pilih Induk Betina</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->tag_number }}" {{ old('dam_tag_number') == $parent->tag_number ? 'selected' : '' }}>{{ $parent->tag_number }}</option>
                                @endforeach
                            </select>
                            @error('dam_tag_number')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="sire_tag_number">Induk Jantan (Tag Number)</label>
                            <select class="form-control @error('sire_tag_number') is-invalid @enderror" id="sire_tag_number" name="sire_tag_number">
                                <option value="">Pilih Induk Jantan</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->tag_number }}" {{ old('sire_tag_number') == $parent->tag_number ? 'selected' : '' }}>{{ $parent->tag_number }}</option>
                                @endforeach
                            </select>
                            @error('sire_tag_number')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan">{{ old('notes') }}</textarea>
                            @error('notes')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="photo_path">Path Foto (Opsional)</label>
                            <input type="text" class="form-control @error('photo_path') is-invalid @enderror" id="photo_path" name="photo_path" value="{{ old('photo_path') }}" placeholder="Masukkan Path Foto atau URL">
                            @error('photo_path')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('ternak.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            </div>
    </section>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script>
        console.log("Halaman Tambah Data Ternak!");
    </script>
@stop