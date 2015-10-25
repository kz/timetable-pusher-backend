<?php

namespace TimetablePusher\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Queue\Connectors\BeanstalkdConnector;
use Pheanstalk\Pheanstalk;

class ClearBeanstalkdQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:beanstalkd:clear {queue?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Beanstalkd queue.';

    /**
     * @param BeanstalkdConnector $connector
     */
    public function handle(BeanstalkdConnector $connector)
    {
        $config = config('queue.connections.beanstalkd');
        /** @type Pheanstalk $pheanstalk */
        $pheanstalk = $connector->connect($config)->getPheanstalk();

        $queue = $this->argument('queue') ?: $config['queue'];
        $this->info("Clearing queue: {$queue}");

        $pheanstalk->useTube($queue);
        $pheanstalk->watch($queue);
        while ($job = $pheanstalk->reserve(0)) {
            $pheanstalk->delete($job);
        }
        $this->info('...cleared.');
    }
}
