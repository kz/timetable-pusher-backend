<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        $apiToken = $user->api_token;
        $timetables = $user->timetables;

        return view('dashboard', compact('apiToken', 'timetables'));
    }
}
