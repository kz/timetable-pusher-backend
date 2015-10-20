<?php

namespace TimetablePusher;

use Illuminate\Database\Eloquent\Model;

/**
 * TimetablePusher\Pin
 *
 * @property integer $id
 * @property integer $job_id
 * @property string $pin_id
 * @property string $time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \TimetablePusher\Job $job
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Pin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Pin whereJobId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Pin wherePinId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Pin whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Pin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\Pin whereUpdatedAt($value)
 */
class Pin extends Model
{
    public function job()
    {
        return $this->belongsTo('TimetablePusher\Job');
    }
}
