<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    public function pins()
    {
        return $this->hasMany(Pin::class);
    }
}
