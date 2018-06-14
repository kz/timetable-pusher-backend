@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Reset Password</h1>

        <form method="POST" action="/password/reset">
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">

            <p>

            <div class="input-field col s12">
                <input id="email" name="email" type="email" value="{{ old('email') }}"/>
                <label for="email">Email</label>
            </div>
            </p>

            <p>

            <div class="input-field col s12">
                <input id="password" name="password" type="password"/>
                <label for="password">Password</label>
            </div>
            </p>

            <p>
            <div class="input-field col s12">
                <input id="password_confirmation" name="password_confirmation" type="password"/>
                <label for="password_confirmation">Password Confirmation</label>
            </div>
            </p>

            <p>
                <button class="btn waves-effect waves-light" type="submit" name="action">Reset Password
                </button>
            </p>
        </form>
    </div>
@endsection