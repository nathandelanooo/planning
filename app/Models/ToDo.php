<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $table = 'to_do_list';
    protected $primaryKey = 'id_to_do_list';

    public $timestamps = false;
    protected $fillable = [
        'judul_list',
        'isi_list',
        'tanggal_mulai',
        'waktu_mulai',
        'tanggal_selesai',
        'waktu_selesai',
        'status'
    ];
}
