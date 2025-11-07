<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    //
    protected $table = 'polis';
    protected $fillable = [
        'nama_poli',
        'ruangan',
        'deskripsi',
        'status',
        'created_by',
    ];

     public function dokters()
    {
        return $this->hasMany(Dokter::class);
    }
}
