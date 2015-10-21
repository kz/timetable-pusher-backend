<?php

namespace TimetablePusher\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use TimetablePusher\Http\Requests;
use TimetablePusher\Http\Controllers\Controller;
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

        return 'asdf';
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
