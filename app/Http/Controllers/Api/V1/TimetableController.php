<?php

namespace TimetablePusher\Http\Controllers\Api\V1;

use Auth;
use Illuminate\Http\Request;
use TimetablePusher\Http\Requests;
use TimetablePusher\Http\Controllers\Controller;
use TimetablePusher\TimetablePusher\Entities\Timetable;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Timetable::whereUserId(Auth::user()->id)->get();
    }
}
