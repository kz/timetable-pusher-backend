<?php

namespace TimetablePusher\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use TimetablePusher\Http\Requests;
use TimetablePusher\Http\Controllers\Controller;
use TimetablePusher\Timetable;
use TimetablePusher\TimetablePusher\Hot;

class TimetableController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('timetable.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1',
            'hotData' => 'required'
        ]);

        $hot = new Hot();
        $hot->parseHotFormatJson($request->input('hotData'));

        $hotValidator = $hot->validateHotFormatData();
        if ($hotValidator !== true) {
            return redirect()->back()->withInput()->withErrors($hotValidator);
        }

        $timetable = new Timetable();
        $timetable->user_id = Auth::user()->id;
        $timetable->name = $request->input('name');
        $timetable->data = $hot->stringifyHotFormatData();
        $timetable->save();

        return redirect('/timetables/' . $timetable->id)->with(['success' => ['Your timetable has successfully been created.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
