<?php

namespace TimetablePusher;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    public function job()
    {
        return $this->belongsTo('TimetablePusher\Job');
    }
}
