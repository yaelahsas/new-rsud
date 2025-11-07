<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inovasi extends Model
{
    //
    protected $table = 'inovasis';
    protected $fillable = [
        'nama_inovasi',
        'slug',
        'deskripsi',
        'gambar',
        'link',
        'status',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'inovasi_id');
    }
}
