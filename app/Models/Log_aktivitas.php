<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log_aktivitas extends Model
{
    //
    protected $table = 'log_aktivitas';
    protected $fillable = [
        'user_id',
        'aksi',
        'modul',
        'detail',
        'ip',
    ];
}
