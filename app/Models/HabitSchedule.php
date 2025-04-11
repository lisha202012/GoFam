<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['habit_id', 'date', 'start_time','end_time'];

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}
