<?php

namespace TimetablePusher\Commands;

use TimetablePusher\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class ClearBeanstalkdQueue extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
