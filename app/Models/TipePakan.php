<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipePakan extends Model
{
    use HasFactory;

    protected $table = 'tipe_pakan';
    protected $fillable = ['name'];

    /**
     * Satu Tipe Pakan bisa dimiliki oleh banyak Pakan.
     */
    public function pakan(): HasMany
    {
        return $this->hasMany(Pakan::class);
    }
}
