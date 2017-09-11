@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col offset-s2 s8">
                @include('layouts.alerts')

                <h1 class="header">Log In</h1>

                <div class="card-panel black-text">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="input-field inline">
                            <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}"/>
                            <label for="email">Email</label>
                        </div>

                        <div class="input-field inline">
                            <input id="password" name="password" type="password" class="validate"/>
                            <label for="password">Password</label>
                        </div>

                        <p>
                            <input type="checkbox" name="remember" id="remember"/>
                            <label for="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me</label>
                        </p>

                        <p>
                            <button class="btn waves-effect waves-light" type="submit" name="action">Log In</button>
                        </p>

                        <p>
                            <a href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection