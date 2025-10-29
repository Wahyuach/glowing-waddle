<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ternak extends Model
{
    use HasFactory;

    // Jika nama tabel di database adalah 'ternak' (bukan default 'ternaks')
    // protected $table = 'ternak';

    protected $primaryKey = 'tag_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tag_number',
        'tag_lama',
        'species_id',
        'kategori_id',
        'sub_kategori_id',
        'tipe_domba_id',
        'jenis_domba_id',
        'gender',
        'date_of_birth',
        'date_of_entry',
        'usia_masuk_dalam_bulan',
        'entry_weight',
        'current_weight',
        'last_weight_date',
        'upweight',
        'kondisi_id',
        'status_id',
        'kandang_id',
        'dam_tag_number',
        'sire_tag_number',
        'notes',
        'photo_path'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class);
    }

    public function tipeDomba()
    {
        return $this->belongsTo(TipeDomba::class);
    }

    public function jenisDomba()
    {
        return $this->belongsTo(JenisDomba::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'kandang_id');
    }

    public function dam()
    {
        return $this->belongsTo(Ternak::class, 'dam_tag_number', 'tag_number');
    }

    public function sire()
    {
        return $this->belongsTo(Ternak::class, 'sire_tag_number', 'tag_number');
    }

    public function weightHistories()
    {
        return $this->hasMany(WeightHistory::class, 'ternak_tag_number', 'tag_number');
    }

        public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'tag_number', 'tag_number');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Hitung umur ternak dalam hari.
     */
    public function getUmurHariAttribute()
    {
        // Menggunakan floor() untuk membulatkan ke bawah ke bilangan bulat terdekat
        // Atau (int) untuk mengkonversi langsung ke integer, yang juga membulatkan ke bawah
        return $this->date_of_birth
            ? floor(Carbon::parse($this->date_of_birth)->diffInDays(Carbon::now()))
            : null;
    }

    /**
     * Hitung jumlah hari ternak berada di peternakan.
     */
    public function getHariDiPeternakanAttribute()
    {
        return $this->date_of_entry
            ? floor(Carbon::parse($this->date_of_entry)->diffInDays(Carbon::now()))
            : null;
    }
}