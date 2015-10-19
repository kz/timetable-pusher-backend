<?php

namespace TimetablePusher;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    public function jobs()
    {
        return $this->hasMany('TimetablePusher\Job');
    }
}
