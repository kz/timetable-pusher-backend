<?php

namespace TimetablePusher\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use TimetablePusher\Http\Requests;
use TimetablePusher\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show()
    {
        $user = Auth::user();

        $apiToken = $user->api_token;
        $timetables = $user->timetables;

        return view('dashboard', compact('apiToken'));
    }
}
