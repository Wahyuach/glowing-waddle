<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Abk extends Model
{
      use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abk';

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
        'address',
        'photo_path',
    ];
}
