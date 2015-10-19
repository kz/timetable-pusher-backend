@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Register</h1>

        <form method="POST" action="/auth/register" class="col s12">
            {!! csrf_field() !!}

            <p>

            <div class="input-field col s12">
                <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}"/>
                <label for="email">Email</label>
            </div>
            </p>

            <p>

            <div class="input-field col s12">
                <input id="password" name="password" type="password" class="validate"/>
                <label for="password">Password</label>
            </div>
            </p>

            <p>
            <div class="input-field col s12">
                <input id="password_confirmation" name="password_confirmation" type="password" class="validate"/>
                <label for="password_confirmation">Password Confirmation</label>
            </div>
            </p>

            <p>
                <button class="btn waves-effect waves-light" type="submit" name="action">Register
                </button>
            </p>

        </form>

    </div>
@endsection