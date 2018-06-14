@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Log In</h1>

        <form method="POST" action="/auth/login" class="col s12">
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
                <input type="checkbox" name="remember" id="remember"/>
                <label for="remember">Remember Me</label>
            </p>

            <p>
                <button class="btn waves-effect waves-light" type="submit" name="action">Log In
                </button>
            </p>

            <p>Forgot your password? Reset it <a href="/password/email">here</a>.</p>

        </form>

    </div>
@endsection