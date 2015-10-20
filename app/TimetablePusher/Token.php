<?php

namespace TimetablePusher\TimetablePusher;

use DB;

class Token
{
    protected $db;

    public function __construct()
    {
        //
    }

    /**
     * @return string
     */
    public function generateUnique()
    {
        while (true) {
            $apiToken = strtoupper(str_random(20));
            if (DB::table('users')->where('api_token', $apiToken)->count() > 0) {
                continue;
            } else {
                break;
            }
        }

        /** @noinspection PhpUndefinedVariableInspection */

        return $apiToken;
    }
}