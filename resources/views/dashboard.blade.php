@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Dashboard</h1>

        <div class="row">
            <div class="card white black-text">
                <div class="card-content black-text">
                    <span class="card-title black-text">API Token</span>
                    <input value="{{ $apiToken }}" type="text">

                    <p>Copy and paste the above token into the Pebble app's configuration page. This will allow the
                        watchapp to access your account.
                        <br/> If you believe this token has been compromised, regenerate the token.</p>
                </div>
                <div class="card-action">
                    <div class="right-align">
                        <form method="POST" action="/token/regenerate">
                            {!! csrf_field() !!}
                            <button type="submit" class="waves-effect waves-light red darken-2 btn">Regenerate Token
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card white black-text">
                <div class="card-content black-text">
                    <span class="card-title black-text">Timetables</span>
                    @if (count($timetables) === 0)
                        <p>You don't have any timetables yet. Why not create one?</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timetables as $timetable)
                                    <tr>
                                        <td>{{ $timetable->name }}</td>
                                        <td><a href="/timetable/{{ $timetable->id }}">View</a> | <a href="/timetable/{{ $timetable->id }}/edit">Edit</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-action">
                    <a href="/timetable/create">
                        <button class="waves-effect waves-light green btn">New Timetable</button>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection