<?php

namespace TimetablePusher\TimetablePusher\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * TimetablePusher\TimetablePusher\Entities\Job
 *
 * @property integer $id
 * @property integer $timetable_id
 * @property integer $pins_sent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \TimetablePusher\TimetablePusher\Entities\Timetable $timetable
 * @property-read \Illuminate\Database\Eloquent\Collection|\TimetablePusher\TimetablePusher\Entities\Pin[] $pins
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Job whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Job whereTimetableId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Job wherePinsSent($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Job whereUpdatedAt($value)
 * @property string $type
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Job whereType($value)
 */
class Job extends Model
{
    public function timetable()
    {
        return $this->belongsTo('TimetablePusher\TimetablePusher\Entities\Timetable');
    }

    public function pins()
    {
        return $this->hasMany('TimetablePusher\TimetablePusher\Entities\Pin');
    }
}
