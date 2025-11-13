<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dokter extends Model
{
    //
    protected $table = 'dokters';
    protected $fillable = [
        'nama',
        'slug',
        'spesialis',
        'poli_id',
        'foto',
        'kontak',
        'status',
    ];
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($dokter) {
            $dokter->slug = Str::slug($dokter->nama);
        });
        
        static::updating(function ($dokter) {
            $dokter->slug = Str::slug($dokter->nama);
        });
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal_poli::class);
    }
}
