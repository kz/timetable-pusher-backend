<?php

namespace TimetablePusher\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use TimetablePusher\Http\Requests;
use TimetablePusher\Http\Controllers\Controller;
use TimetablePusher\Timetable;
use TimetablePusher\TimetablePusher\Hot;
use Validator;

class JobController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'timetable_id' => 'required|integer',
            'offset_from_utc' => 'required|integer',
            'week' => 'required|string|in:current,next',
            'day' => 'sometimes|integer|min:0|max:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'messages' => $validator->messages()], 400);
        }

        try {
            $timetable = Timetable::findOrFail($request->input('timetable_id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'messages' => ['timetable' => 'Timetable not found.']], 404);
        }

        $nowInUTC = Carbon::now('UTC')
            ->addMinutes($request->input('offset_from_utc'));
        if ($request->input('week') === 'current') {
            $weekBeginning = $nowInUTC->startOfWeek();
        } else {
            $weekBeginning = $nowInUTC->addWeek()->startOfWeek();
        }

        $hot = new Hot();
        $hot->parseJson($timetable->data);
        $output = $hot->outputHotFormatToPinFormat($weekBeginning, $request->input('offset_from_utc'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
