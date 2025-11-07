<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori_berita extends Model
{
    //
    protected $table = 'kategori_beritas';
    protected $fillable = [
        'nama_kategori',
        'slug',
    ];
    
    // Accessor untuk menyediakan field 'nama' agar kompatibel dengan kode yang ada
    public function getNamaAttribute()
    {
        return $this->nama_kategori;
    }

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }
}
