<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class JenisDomba extends Model
{
    use HasFactory;
    protected $table = 'jenis_domba';
    protected $fillable = ['name'];
    
}