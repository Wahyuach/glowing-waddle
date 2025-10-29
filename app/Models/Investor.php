<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Investor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'investors';

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
        'phone_number',
        'address'
    ];

        public function kavlings(): HasMany
    {
        return $this->hasMany(Kavling::class);
    }


}
