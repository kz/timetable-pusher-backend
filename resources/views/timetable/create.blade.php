@extends('layouts.master')

@section('extra-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/handsontable/0.19.0/handsontable.full.min.css">
@endsection

@section('extra-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handsontable/0.19.0/handsontable.full.min.js"></script>
    <script src="/js/handsontable-create.js"></script>
@endsection

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Create a Timetable</h1>

        <div class="row">
            <div class="card-panel black-text">
                <p>Enter the amount of lessons you have per day below:
                    <input value="7" id="lessons" type="number" min="1" max="14" class="validate"/>
                </p>
                <button class="waves-effect waves-light btn" onclick="generateTimetable()"
                        id="generate-timetable-button">Generate Timetable
                </button>
            </div>
        </div>

        <div id="post-creation" style="display: none;">
            <div class="row">
                <div class="card-panel black-text">
                    <p>Modify your lesson times and fill in the names and locations of your classes below.
                        <br/> All fields are optional, so leave fields blank if you don't have classes (e.g., Sunday).
                        <br/><strong>Tip:</strong> Type your timetable into a spreadsheet, save it somewhere safe and
                        paste your lessons here to prevent data loss!
                    </p>

                    <div id="handsontable-container"></div>
                    <p>Make sure you save your timetable below!</p>
                </div>
            </div>

            <div class="row">
                <div class="card-panel black-text">
                    <form id="create" method="POST" action="/timetable/create">
                        {!! csrf_field() !!}
                        <p>Name your timetable below:
                            <input placeholder="Name (e.g., Week A)" name="name" id="name" value="{{ old('name') }}"
                                   type="text"
                                   class="validate"/>
                        </p>
                        <p>
                            <input type="checkbox" class="filled-in" name="hasPeriodNumbers" id="hasPeriodNumbers" value="true" checked="checked"/>
                            <label for="hasPeriodNumbers">Include period numbers (e.g., Timeline has "1 - Maths" instead of "Maths")</label>
                        </p>
                        <input type="hidden" id="hotData" name="hotData" value="{{ old('hotData') }}"/>
                    </form>
                    <button class="waves-effect waves-light btn" onclick="submitForm()"
                            id="generate-timetable-button">Save Timetable
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection