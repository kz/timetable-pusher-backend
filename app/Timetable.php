<?php

namespace TimetablePusher;

use Illuminate\Database\Eloquent\Model;

/**
 * TimetablePusher\Timetable
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\TimetablePusher\Job[] $jobs
 * @property-read \TimetablePusher\User $user
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Timetable whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Timetable whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Timetable whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Timetable whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Timetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Timetable whereUpdatedAt($value)
 */
class Timetable extends Model
{
    public function jobs()
    {
        return $this->hasMany('TimetablePusher\Job');
    }

    public function user()
    {
        return $this->belongsTo('TimetablePusher\User');
    }
}
