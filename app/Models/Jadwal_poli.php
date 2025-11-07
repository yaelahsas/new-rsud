<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal_poli extends Model
{
    //
    protected $table = 'jadwal_polis';
    protected $fillable = [
        'dokter_id',
        'poli_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'is_cuti',
        'tanggal_cuti',
        'keterangan',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
