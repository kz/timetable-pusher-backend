<?php

namespace TimetablePusher\Jobs;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Middleware;
use Log;
use TimetablePusher\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use TimetablePusher\TimetablePusher\Entities\Pin;

class PushPin extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $timelineToken;
    protected $pin;
    protected $jobId;

    /**
     * Create a new job instance.
     *
     * @param $timelineToken
     * @param $pin
     * @param $jobId
     */
    public function __construct($timelineToken, $pin, $jobId)
    {
        $this->timelineToken = $timelineToken;
        $this->pin = $pin;
        $this->jobId = $jobId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Store new pin in DB, automatically generating a pin ID
        $dbPin = new Pin();
        $dbPin->job_id = $this->jobId;
        $dbPin->status = 'in_progress';
        $dbPin->time = Carbon::parse($this->pin['time']);
        $dbPin->save();

        // Add pin ID to pin
        $this->pin['id'] = $dbPin->pin_id;

        $client = new Client(['base_uri' => 'https://timeline-api.getpebble.com/v1/user/pins/']);

        // Grab the client's handler instance.
        $clientHandler = $client->getConfig('handler');
        // Create a middleware that echoes parts of the request.
        $tapMiddleware = Middleware::tap(function ($request) {
            Log::error($request->getBody());
            // {"foo":"bar"}
        });

        try {
            $response = $client->request('PUT', $dbPin->pin_id, [
                'json' => $this->pin,
                'headers' => [
                    'X-User-Token' => $this->timelineToken,
                ],
                'handler' => $tapMiddleware($clientHandler)
            ]);

            if ($response->getStatusCode() === 200) {
                $dbPin->status = 'successful';
            } else {
                $dbPin->status = 'failed';
                Log::error('Pin Failure - ' . $dbPin->id . ' due to ' . $response->getStatusCode() . ' - ' . $response->getBody());
            }
            $dbPin->status_code = $response->getStatusCode();
            $dbPin->response = $response->getBody();
            $dbPin->update();
        } catch (RequestException $e) {
            $responseCode = $e->getResponse()->getStatusCode();
            $responseBody = $e->getResponse()->getBody();

            Log::error('Pin Failure - API - ' . $dbPin->id . ' due to ' . $responseCode . ' - ' . $responseBody);

            $dbPin->status = 'failed';
            $dbPin->status_code = $responseCode;
            $dbPin->response = $responseBody;
            $dbPin->update();
        } catch (TransferException $e) {
            $responseCode = $e->getResponse()->getStatusCode();
            $responseBody = $e->getResponse()->getBody();

            Log::error('Pin Failure - Network - ' . $dbPin->id . ' due to ' . $responseCode . ' - ' . $responseBody);

            $dbPin->status = 'failed';
            $dbPin->status_code = $responseCode;
            $dbPin->response = $responseBody;
            $dbPin->update();
        }

    }
}
