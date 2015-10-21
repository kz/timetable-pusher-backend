<?php

namespace TimetablePusher\TimetablePusher;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use TimetablePusher\Jobs\PushPin;
use TimetablePusher\TimetablePusher\Entities\Timetable;

class Job
{

    use DispatchesJobs;

    public function __construct()
    {

    }

    public function pushPins($timetableId, $timetableToken, $pins)
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
                $this->dispatch(new PushPin($timetableToken, $pin, $job->id));
            }
        }

        $job->update();
    }
}