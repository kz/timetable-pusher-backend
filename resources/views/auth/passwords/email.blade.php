@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col offset-s2 s8">
                @include('layouts.alerts')

                <h1 class="header">Reset Password</h1>

                <div class="card-panel black-text">
                    <p>In order to reset your password, complete this form and you will be sent an email containing a password reset link.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="input-field">
                            <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}"/>
                            <label for="email">Email</label>
                        </div>

                        <p>
                            <button class="btn waves-effect waves-light" type="submit" name="action">Send Password Reset Link</button>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection