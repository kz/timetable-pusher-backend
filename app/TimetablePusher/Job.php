<?php

namespace TimetablePusher\TimetablePusher;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use TimetablePusher\TimetablePusher\Entities\Timetable;

class Job
{
    public function __construct()
    {

    }

    public function createPins($timetableId, $timetableToken, $pins)
    {
        try {
            $timetable = Timetable::findOrFail($timetableId);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException;
        }

        $job = new Entities\Job();
        $job->timetable_id = $timetable->id;
        $job->save();

        $job->pin_count = 0;

        foreach($pins as $pinDay) {
            foreach($pinDay as $pin) {
                $job->pin_count += 1;


            }
        }

        $job->update();

    }
}