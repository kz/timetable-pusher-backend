<?php

namespace TimetablePusher\Jobs;

use TimetablePusher\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePins extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $timetableToken;
    protected $pins;

    /**
     * Create a new job instance.
     *
     * @param $timetableToken
     * @param $pins
     */
    public function __construct($timetableToken, $pins)
    {
        $this->timetableToken = $timetableToken;
        $this->pins = $pins;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }
}
