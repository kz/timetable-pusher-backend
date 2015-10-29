<?php

namespace TimetablePusher\Jobs;

use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Log;
use TimetablePusher\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use TimetablePusher\TimetablePusher\Entities\Pin;

class DeletePin extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $timelineToken;
    private $pinId;

    /**
     * Create a new job instance.
     * @param $timelineToken
     * @param $pinId
     */
    public function __construct($timelineToken, $pinId)
    {
        $this->timelineToken = $timelineToken;
        $this->pinId = $pinId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::connection()->reconnect();

        $pin = Pin::findOrFail($this->pinId);

        $client = new Client(['base_uri' => 'https://timeline-api.getpebble.com/v1/user/pins/']);
        try {
            $response = $client->delete($pin->pin_id, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-User-Token' => $this->timelineToken,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $pin->status = 'deleted';
                $pin->status_code = $response->getStatusCode();
                $pin->response = $response->getBody();
                $pin->update();
            } else {
                Log::error('Pin Delete Failure - ' . $pin->id . ' due to ' . $response->getStatusCode() . ' - ' . $response->getBody());
            }
        } catch (RequestException $e) {
            $responseCode = $e->getResponse()->getStatusCode();
            $responseBody = $e->getResponse()->getBody();

            Log::error('Pin Delete Failure - API - ' . $pin->id . ' due to ' . $responseCode . ' - ' . $responseBody);
        } catch (TransferException $e) {
            $responseCode = $e->getResponse()->getStatusCode();
            $responseBody = $e->getResponse()->getBody();

            Log::error('Pin Delete Failure - Network - ' . $pin->id . ' due to ' . $responseCode . ' - ' . $responseBody);
        }

    }
}
