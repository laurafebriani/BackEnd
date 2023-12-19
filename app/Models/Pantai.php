<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pantai extends Model
{
    use HasFactory;
    protected $table = 'pantais';
    protected $fillable = [
        'nama_pantai',
        'gambar',
        'deskripsi',
        

    ];
}
