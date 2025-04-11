<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $fillable = ['user_id', 'mood', 'mood_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

