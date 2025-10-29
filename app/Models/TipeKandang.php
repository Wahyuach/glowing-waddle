<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class TipeKandang extends Model
{
   use HasFactory;

    protected $table = 'tipe_kandang';
    protected $fillable = ['name'];

    /**
     * Satu Tipe Kandang bisa dimiliki oleh banyak Kandang.
     */
    public function kandangs(): HasMany
    {
        return $this->hasMany(Kandang::class);
    }
}
