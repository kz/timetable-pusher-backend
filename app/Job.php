<?php

namespace TimetablePusher;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function timetable()
    {
        return $this->belongsTo('TimetablePusher\Timetable');
    }

    public function pins()
    {
        return $this->hasMany('TimetablePusher\Pin');
    }
}
