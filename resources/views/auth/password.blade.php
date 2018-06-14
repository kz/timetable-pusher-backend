@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.alerts')

        <h1 class="header">Reset Password</h1>

        <form method="POST" action="/password/email">
            {!! csrf_field() !!}

            <p>

            <div class="input-field col s12">
                <input id="email" name="email" type="email" value="{{ old('email') }}"/>
                <label for="email">Email</label>
            </div>
            </p>

            <p>
                <button class="btn waves-effect waves-light" type="submit" name="action">Send Password Reset Link
                </button>
            </p>
        </form>
    </div>
@endsection