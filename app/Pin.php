<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // TODO: Needs test
            // Ensure a unique API token is generated
            $pinId = 'timetable-' . Pin::generateUniquePinId();

            $model->pin_id = $pinId;
        });
    }

    // TODO: This is horrible!
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
