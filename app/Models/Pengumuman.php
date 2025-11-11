<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    //
    protected $table = 'pengumuman';
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif',
    ];
    
    protected $casts = [
        'aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
