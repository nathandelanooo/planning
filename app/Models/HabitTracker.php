<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitTracker extends Model
{
    protected $table = 'habit_tracker';
    protected $primaryKey = 'id_habit_tracker';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'nama_habit',
        'kategori_habit',
        'status',
    ];
}
