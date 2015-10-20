<?php

namespace TimetablePusher\Http\Controllers;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        return redirect('/timetable/' . $timetable->id)->with(['success' => ['Your timetable has successfully been created.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $timetable = Timetable::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

        if ($timetable->user_id !== Auth::user()->id) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

        $hot = new Hot();
        $hot->parseHotFormatJson($timetable->data);
        $rows = $hot->outputViewableFormat();

        return view('timetable.show')->with(compact('timetable', 'rows'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $timetable = Timetable::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

        if ($timetable->user_id !== Auth::user()->id) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

        return view('timetable.edit')->with(compact('timetable'));
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
        try {
            $timetable = Timetable::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

        if ($timetable->user_id !== Auth::user()->id) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

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

        $timetable->name = $request->input('name');
        $timetable->data = $hot->stringifyHotFormatData();
        $timetable->update();

        return redirect('/timetable/' . $timetable->id)->with(['success' => ['Your timetable has successfully been updated.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $timetable = Timetable::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

        if ($timetable->user_id !== Auth::user()->id) {
            return redirect('/dashboard')->withErrors('Timetable not found.');
        }

        $timetable->delete();

        return redirect('/dashboard')->with(['success' => ['Your timetable has successfully been deleted.']]);
    }
}
