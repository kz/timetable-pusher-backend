@extends('layouts.master')

@section('content')
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>

            <h1 class="header center white-text">Class Timetables on your Wrist</h1>

            <div class="row center">
                <h5 class="header col s12 white-text light">Timetable Pusher is a Pebble app which pushes your class
                    timetables to your watch.</h5>
            </div>
            <div class="row center">
                <a href="https://apps.getpebble.com/en_US/application/562a89497480835e51000090" id="download-button"
                   class="btn-large waves-effect waves-light red">1. Download the App</a>
                <a href="/dashboard" id="download-button"
                   class="btn-large waves-effect waves-light red">2. Configure your Timetable</a>
            </div>
            <br><br>

        </div>
    </div>
@endsection