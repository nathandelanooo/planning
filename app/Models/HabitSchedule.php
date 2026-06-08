<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitSchedule extends Model
{
    protected $table = 'habit_schedule';
    protected $primaryKey = 'id_schedule';

    protected $fillable = [
        'id_schedule',
        'id_habit_tracker',
        'hari',
        'reminder_time'
    ];
}
