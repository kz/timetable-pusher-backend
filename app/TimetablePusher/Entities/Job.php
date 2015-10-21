<?php

namespace TimetablePusher\TimetablePusher\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * TimetablePusher\Job
 *
 * @property integer $id
 * @property string $status
 * @property integer $timetable_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $ended_at
 * @property-read \TimetablePusher\Timetable $timetable
 * @property-read \Illuminate\Database\Eloquent\Collection|\TimetablePusher\Pin[] $pins
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Job whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Job whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Job whereTimetableId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Job whereEndedAt($value)
 */
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
