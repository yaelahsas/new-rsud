<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';
    protected $fillable = [
        'nama',
        'rating',
        'pesan',
        'inovasi_id',
    ];

    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class, 'inovasi_id');
    }
}
