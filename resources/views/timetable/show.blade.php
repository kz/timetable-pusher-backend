@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Timetable - {{ $timetable->name }}</h1>

        <div class="row">
            <div class="card-panel black-text">
                <table class="bordered">
                    <thead>
                    <tr>
                        <th>Period</th>
                        <th>Times</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rows as $row)
                        <tr>
                            @for($i = 0; $i < count($row); $i++)
                                <td>{!! $row[$i] !!}</td>
                            @endfor
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>
                    <a href="/timetable/{{ $timetable->id }}/edit">
                        <button class="waves-effect waves-light green btn">Edit</button>
                    </a>
                </p>
                <form method="POST" action="/timetable/{{ $timetable->id }}/delete">
                    {!! csrf_field() !!}
                    <button type="submit" class="right waves-effect waves-light red darken-2 btn">Delete</button>
                </form><br />

            </div>
        </div>

    </div>
@endsection