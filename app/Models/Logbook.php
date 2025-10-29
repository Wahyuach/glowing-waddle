<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $primaryKey = 'logbook';
    public $incrementing = false; // karena `logbook` bukan integer auto-increment

    protected $fillable = [
        'logbook',
        'tag_number',
        'tanggal_kejadian',
    ];

    public function ternak()
    {
        return $this->belongsTo(Ternak::class, 'tag_number', 'tag_number');
    }

        public function Kejadian()
    {
        return $this->belongsTo(Kejadian::class);
    }
}
