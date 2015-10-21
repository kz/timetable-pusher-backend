<?php

namespace TimetablePusher\TimetablePusher\Entities;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * TimetablePusher\TimetablePusher\Entities\Pin
 *
 * @property integer $id
 * @property integer $job_id
 * @property string $status
 * @property string $pin_id
 * @property string $time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \TimetablePusher\TimetablePusher\Entities\Job $job
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereJobId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin wherePinId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereUpdatedAt($value)
 * @property integer $status_code
 * @property string $response
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereStatusCode($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\Pin whereResponse($value)
 */
class Pin extends Model
{
    public function job()
    {
        return $this->belongsTo('TimetablePusher\TimetablePusher\Entities\Job');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ensure a unique API token is generated
            $pinId = 'timetable-' . Pin::generateUniquePinId();

            $model->pin_id = $pinId;
        });
    }

    public static function generateUniquePinId()
    {
        while (true) {
            $pinId = strtolower(str_random(10));
            if (DB::table('pins')->where('pin_id', $pinId)->count() > 0) {
                continue;
            } else {
                break;
            }
        }

        /** @noinspection PhpUndefinedVariableInspection */

        return $pinId;
    }
}
