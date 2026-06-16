<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id_notes';

    public $timestamps = false;

    protected $fillable = [
        'judul_notes',
        'isi_notes',
        'voice_memo',
    ];
}
