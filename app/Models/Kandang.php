<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kandang extends Model
{
    use HasFactory;
    protected $table = 'kandang';

    // Properti penting untuk primary key string
    protected $primaryKey = 'kandang_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kandang_id',
        'kavling_id',
        'tipe_kandang_id',
        'kapasitas',
        // 'current_population', // Dihapus dari fillable karena akan dihitung secara real-time
        'notes',
    ];

    public function kavling(): BelongsTo
    {
        return $this->belongsTo(Kavling::class, 'kavling_id', 'no_kavling');
    }

    public function tipeKandang(): BelongsTo
    {
        return $this->belongsTo(TipeKandang::class);
    }

    public function ternaks(): HasMany
    {
        return $this->hasMany(Ternak::class, 'kandang_id', 'kandang_id');
    }

    /**
     * Accessor untuk mendapatkan populasi kandang saat ini secara real-time.
     * Nama accessor harus camelCase dari nama kolom (current_population -> getCurrentPopulationAttribute).
     * Saat diakses sebagai $kandang->current_population, metode ini akan dipanggil.
     */
    public function getCurrentPopulationAttribute(): int
    {
        // Menghitung jumlah ternak yang terkait dengan kandang ini
        return $this->ternaks->count();
    }
}
