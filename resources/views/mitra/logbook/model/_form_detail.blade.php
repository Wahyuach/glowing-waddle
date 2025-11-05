{{-- BLOK 1: KELAHIRAN (Muncul saat Kejadian = Melahirkan) --}}
<div id="form-kelahiran" style="display:none; padding: 15px; border: 1px solid #ddd; margin-top: 15px;">
    <h5><i class="fas fa-baby"></i> Data Kelahiran (K - Z)</h5>
    {{-- BARIS INDUK --}}
    <div class="row">
        <div class="col-md-3"><div class="form-group"><label>Induk Betina (K)</label><input type="text" name="induk_betina" class="form-control" value="{{ old('induk_betina') }}"></div></div>
        <div class="col-md-3"><div class="form-group"><label>Jenis Betina (L)</label><input type="text" name="jenis_betina" class="form-control" value="{{ old('jenis_betina') }}"></div></div>
        <div class="col-md-3"><div class="form-group"><label>Induk Jantan (P)</label><input type="text" name="induk_jantan" class="form-control" value="{{ old('induk_jantan') }}"></div></div>
        <div class="col-md-3"><div class="form-group"><label>Jenis Jantan (Q)</label><input type="text" name="jenis_jantan" class="form-control" value="{{ old('jenis_jantan') }}"></div></div>
    </div>
    
    {{-- BARIS ANAK --}}
    <h6 class="mt-3">Detail Anak</h6>
     <div class="row">
        <div class="col-md-4"><div class="form-group"><label>BB Lahir (X)</label><input type="number" name="bb_lahir" class="form-control" step="0.01" value="{{ old('bb_lahir') }}"></div></div>
        <div class="col-md-4"><div class="form-group"><label>Qty Anak (S)</label><input type="number" name="qty_anak" class="form-control" value="{{ old('qty_anak') }}"></div></div>
        <div class="col-md-4"><div class="form-group"><label>Sex Anak (W)</label><select name="sex_anak" class="form-control"><option value=""></option><option value="Jantan">Jantan</option><option value="Betina">Betina</option></select></div></div>
        
        {{-- Sisa Kolom Kelahiran (Nomor Cempe, Anak, dll) disisipkan di sini --}}
     </div>

</div>

{{-- BLOK 2: PENANGANAN (Muncul saat Kejadian = Sakit/Mati/Kastrasi) (AD - AE) --}}
<div id="form-penanganan" style="display:none; padding: 15px; border: 1px solid #ddd; margin-top: 15px;">
    <h5><i class="fas fa-syringe"></i> Data Penanganan / Sakit (AD - AE)</h5>
     <div class="row">
        <div class="col-md-6"><div class="form-group"><label>Penanganan (AD)</label><textarea name="penanganan" class="form-control">{{ old('penanganan') }}</textarea></div></div>
        <div class="col-md-6"><div class="form-group"><label>Tanggal Sembuh (AE)</label><input type="date" name="tanggal_sembuh" class="form-control" value="{{ old('tanggal_sembuh') }}"></div></div>
    </div>
</div>

{{-- BLOK 3: PINDAH KANDANG (Muncul saat Kejadian = Pindah Kandang) (AB - AC) --}}
<div id="form-pindah-kandang" style="display:none; padding: 15px; border: 1px solid #ddd; margin-top: 15px;">
    <h5><i class="fas fa-exchange-alt"></i> Data Pindah Kandang (AB - AC)</h5>
     <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Kandang Baru (AB)</label>
                {{-- Dropdown ini akan diisi data $kandangs dari Controller --}}
                <select name="kandang_baru_id" class="form-control">
                    <option value="">Pilih Kandang</option>
                    {{-- @foreach($kandangs as $kandang)... --}}
                </select>
            </div>
        </div>
        <div class="col-md-6"><div class="form-group"><label>Kategori Kandang Baru (AC)</label><input type="text" name="kategori_kandang_baru" class="form-control" value="{{ old('kategori_kandang_baru') }}"></div></div>
    </div>
</div>