<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'ternak_tag_number',
        'weight',
        'measurement_date',
    ];

    public function ternak()
    {
        return $this->belongsTo(Ternak::class, 'ternak_tag_number', 'tag_number');
    }
}