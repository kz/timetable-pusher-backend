<?php

namespace TimetablePusher\Http\Controllers\Api\V1;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use TimetablePusher\Http\Requests;
use TimetablePusher\Http\Controllers\Controller;
use TimetablePusher\TimetablePusher\Entities\Timetable;
use TimetablePusher\TimetablePusher\Hot;
use TimetablePusher\TimetablePusher\Job;
use TimetablePusher\TimetablePusher\PinFormatter;
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
        // Validate API input
        $validator = Validator::make($request->all(), [
            'timetable_id' => 'required|integer',
            'timeline_token' => 'required|string',
            'offset_from_utc' => 'required|integer',
            'week' => 'required|string|in:current,next',
            'day' => 'sometimes|integer|min:0|max:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'messages' => $validator->messages()], 400);
        }

        // Retrieve timetable, ensuring it belongs to the user
        try {
            $timetable = Timetable::findOrFail($request->input('timetable_id'));
            if ($timetable->user->id !== Auth::user()->id) {
                throw new ModelNotFoundException;
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'messages' => ['timetable' => 'Timetable not found.']], 404);
        }

        // Get user's week
        $nowInUTC = Carbon::now('UTC')
            ->addMinutes($request->input('offset_from_utc'));
        if ($request->input('week') === 'current') {
            $weekBeginning = $nowInUTC->copy()->startOfWeek();
        } else {
            $weekBeginning = $nowInUTC->copy()->addWeek()->startOfWeek();
        }

        // Ensure the day requested is not prior to user's current day
        if ($request->input('week') === 'current' && $request->has('day')) {
            $dayOfWeek = $nowInUTC->dayOfWeek === 0 ? 6 : $nowInUTC->dayOfWeek - 1;
            if ($request->input('day') < $dayOfWeek) {
                return response()->json(['error' => 'true', 'messages' => ['day' => 'Cannot retrieve previous day.']], 403);
            }
        }

        // Create pins
        $hot = new Hot();
        $hot->parseJson($timetable->data);
        $pins = $hot->outputHotFormatToPinFormat($weekBeginning, $request->input('offset_from_utc'));

        $pinFormatter = new PinFormatter($pins);

        // Remove unnecessary pins if current week requested
        if ($request->input('week') === 'current') {
            $pins = $pinFormatter->removePinsOlderThanCurrentDay();
        }

        // Retrieve pins for specified day only
        if ($request->has('day')) {
            $pins = $pinFormatter->retrievePinsForDay($request->input('day'));
        }

        $job = new Job();
        $job->pushPins($timetable->id, request()->input('timeline_token'), $pins);

        return response()->json('All pins sent.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request)
    {
        // Validate API input
        $validator = Validator::make($request->all(), [
            'timeline_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'messages' => $validator->messages()], 400);
        }

        // Retrieve all successful pins up to the past week
        $pins = DB::table('pins')->where('user_id', Auth::user()->id)
            ->where('status', 'successful')
            ->where('time', '>', Carbon::now()->subDays(3))
            ->get();

        $job = new Job();
        $job->deletePins(request()->input('timeline_token'), $pins);

        return response()->json('Deletion request sent.', 200);
    }
}
