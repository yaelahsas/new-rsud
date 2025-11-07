<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    //
    protected $table = 'beritas';
    protected $fillable = [
        'judul',
        'slug',
        'kategori_id',
        'isi',
        'thumbnail',
        'created_by',
        'publish',
        'tanggal_publish',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori_berita::class, 'kategori_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
