<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
    ];
}
