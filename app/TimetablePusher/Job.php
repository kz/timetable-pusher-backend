<?php

namespace TimetablePusher\TimetablePusher;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use TimetablePusher\Jobs\DeletePin;
use TimetablePusher\Jobs\PushPin;
use TimetablePusher\TimetablePusher\Entities\Timetable;

class Job
{

    use DispatchesJobs;

    public function __construct()
    {

    }

    public function pushPins($timetableId, $timelineToken, $pins)
    {
        try {
            $timetable = Timetable::findOrFail($timetableId);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException;
        }

        $job = new Entities\Job();
        $job->user_id = Auth::user()->id;
        $job->type = 'create';
        $job->timetable_id = $timetable->id;
        $job->save();

        $job->pins_sent = 0;

        foreach($pins as $pinDay) {
            foreach($pinDay as $pin) {
                $job->pins_sent += 1;
                $this->dispatch(new PushPin($timelineToken, $pin, $job->id));
            }
        }

        $job->update();
    }

    public function deletePins($timelineToken, $pins)
    {
        $job = new Entities\Job();
        $job->type = 'delete';
        $job->save();

        $job->pins_sent = 0;

        foreach ($pins as $pin) {
            $job->pins_sent += 1;
            $this->dispatch(new DeletePin($timelineToken, $pin->id));
        }

        $job->update();
    }
}