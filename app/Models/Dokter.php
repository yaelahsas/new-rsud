<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    //
    protected $table = 'dokters';
    protected $fillable = [
        'nama',
        'spesialis',
        'poli_id',
        'foto',
        'kontak',
        'status',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal_poli::class);
    }
}
