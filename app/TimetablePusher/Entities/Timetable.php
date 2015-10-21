<?php

namespace TimetablePusher\TimetablePusher\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * TimetablePusher\TimetablePusher\Entities\Timetable
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\TimetablePusher\TimetablePusher\Entities\Job[] $jobs
 * @property-read \TimetablePusher\TimetablePusher\Entities\User $user
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Timetable whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Timetable whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Timetable whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Timetable whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Timetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Timetable whereUpdatedAt($value)
 */
class Timetable extends Model
{

    use SoftDeletes;

    public function jobs()
    {
        return $this->hasMany('TimetablePusher\TimetablePusher\Entities\Job');
    }

    public function user()
    {
        return $this->belongsTo('TimetablePusher\TimetablePusher\Entities\User');
    }

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['id', 'name'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
