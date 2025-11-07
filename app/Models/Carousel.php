<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $table = 'carousels';
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'link',
        'urutan',
        'aktif',
    ];
    
    protected $casts = [
        'aktif' => 'boolean',
    ];
}
