<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pakan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pakan';

    /**
     * The attributes that are mass assignable.
     *
     * Atribut ini penting untuk keamanan agar hanya kolom-kolom ini
     * yang bisa diisi secara massal (misalnya melalui form).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'tipe_pakan_id', // Ganti 'type' menjadi 'tipe_pakan_id'        
        'stock',
        'unit',
        'price_per_unit',
        'description',
    ];

    /**
     * Setiap Pakan memiliki satu Tipe Pakan.
     */
    public function tipePakan(): BelongsTo
    {
        return $this->belongsTo(TipePakan::class);
    }
}
