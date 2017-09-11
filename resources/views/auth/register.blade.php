@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col offset-s2 s8">
                @include('layouts.alerts')

                <h1 class="header">Register</h1>

                <div class="card-panel black-text">
                    <p>Register for an account in order to create a timetable. It only takes a minute!</p>

                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="input-field">
                            <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}"/>
                            <label for="email">Email</label>
                        </div>

                        <div class="input-field">
                            <input id="password" name="password" type="password" class="validate"/>
                            <label for="password">Password</label>
                        </div>

                        <div class="input-field">
                            <input id="password_confirmation" name="password_confirmation" type="password" class="validate"/>
                            <label for="password_confirmation">Password Confirmation</label>
                        </div>

                        <p>
                            <button class="btn waves-effect waves-light" type="submit" name="action">Register</button>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection