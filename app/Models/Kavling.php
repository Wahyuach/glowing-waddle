<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kavling extends Model
{
    use HasFactory;

    protected $table = 'kavling';
    protected $primaryKey = 'no_kavling';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_kavling',
        'kapasitas',
        'status_kepemilikan',
        'investor_id',
        'abk_id',
    ];

    public function investor(): BelongsTo
    {
        return $this->belongsTo(Investor::class);
    }

    public function abk(): BelongsTo
    {
        return $this->belongsTo(Abk::class);
    }

    public function kandangs(): HasMany
    {
        return $this->hasMany(Kandang::class, 'kavling_id', 'no_kavling');
    }

    public function ternaks(): HasMany
    {
        return $this->hasMany(Ternak::class, 'kavling_id', 'no_kavling');
    }

    /**
     * Accessor untuk mendapatkan total populasi ternak dari semua kandang di kavling ini secara real-time.
     */
    public function getJumlahPopulasiKandangAttribute(): int
    {
        // current_population di Kandang adalah accessor yang menghitung ternak.
        return $this->kandangs->sum(function ($kandang) {
            return $kandang->current_population; // Memanggil accessor current_population dari model Kandang
        });
    }
}
