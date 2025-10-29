<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SubKategori extends Model
{
    use HasFactory;
    protected $table = 'sub_kategori';
    protected $fillable = ['name'];
    
}