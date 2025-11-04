<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'logbooks';

    /**
     * Kolom-kolom yang boleh diisi (mass assignable). 
     * Ini harus didaftarkan semua sesuai migration (B sampai AA).
     */
    protected $fillable = [
        'tanggal_kejadian',
        'ternak_tag_number',
        'kandang_lama_id', // Nama kolom yang kita pakai di migration
        'kategori_kandang',
        'jenis_ternak',
        'sex',
        'kejadian',
        'abk',
        'tag_baru',

        // Kolom K sampai Z (Kelahiran)
        'induk_betina',
        'jenis_betina',
        'bb_betina',
        'umur_betina',
        'foto_betina',
        'induk_jantan',
        'jenis_jantan',
        'foto_jantan',
        'tipe_kelahiran',
        'qty_anak',
        'nomor_cempe',
        'anak',
        'sex_anak',
        'bb_lahir',
        'foto_anak',
        'jenis_anak',
        
        // Kolom AA sampai AG (Lanjutan/Lain-lain)
        'keterangan',
        'kandang_baru_id', // Nama kolom yang kita pakai di migration
        'kategori_kandang_baru',
        'penanganan',
        'tanggal_sembuh',
        'nomor_semen',
        'jenis_semen',
    ];

    /**
     * Kolom yang harus dikonversi ke tipe data tertentu.
     */
    protected $casts = [
        'tanggal_kejadian' => 'datetime',
        'tanggal_sembuh' => 'date',
    ];

    /**
     * Relasi ke Ternak
     */
    public function ternak()
    {
        return $this->belongsTo(Ternak::class, 'ternak_tag_number', 'tag_number');
    }
    
    /**
     * Relasi ke Kandang Lama
     */
    public function kandangLama()
    {
        // Ganti 'kandang_id' menjadi 'kandang_lama_id' untuk Logbook
        return $this->belongsTo(Kandang::class, 'kandang_lama_id', 'kandang_id');
    }

    /**
     * Relasi ke Kandang Baru (Jika ada pindah kandang)
     */
    public function kandangBaru()
    {
        // Ganti 'kandang_id' menjadi 'kandang_baru_id' untuk Logbook
        return $this->belongsTo(Kandang::class, 'kandang_baru_id', 'kandang_id');
    }

    // Sampeyan bisa tambahkan relasi ke model Induk Betina/Jantan, ABK, dll di sini
}
