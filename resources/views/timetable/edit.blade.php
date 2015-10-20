@extends('layouts.master')

@section('extra-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/handsontable/0.19.0/handsontable.full.min.css">
@endsection

@section('extra-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handsontable/0.19.0/handsontable.full.min.js"></script>
    <script src="/js/handsontable-edit.js"></script>
@endsection

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Editing Timetable - {{ $timetable->name }}</h1>

        <div class="row">
            <div class="card-panel black-text">
                <p>Modify your lesson times and fill in the names and locations of your classes below.
                    <br/> All fields are optional, so leave fields blank if you don't have classes (e.g., Sunday).
                </p>

                <div id="handsontable-container"></div>
                <p>Make sure you save your stimetable below!</p>
            </div>
        </div>

        <div class="row">
            <div class="card-panel black-text">
                <form id="create" method="POST" action="/timetable/{{ $timetable->id }}/edit">
                    {!! csrf_field() !!}
                    <p>

                    <div class="input-field">
                        <input placeholder="Name (e.g., Week A)" name="name" id="name"
                               value="{{ old('name', $timetable->name) }}"
                               type="text"
                               class="validate"/>
                        <label for="name">Name</label>
                    </div>
                    </p>
                    <input type="hidden" id="hotData" name="hotData" value="{{ old('hotData', $timetable->data) }}"/>
                </form>
                <button class="waves-effect waves-light btn" onclick="submitForm()"
                        id="generate-timetable-button">Update Timetable
                </button>
            </div>
        </div>
    </div>
@endsection