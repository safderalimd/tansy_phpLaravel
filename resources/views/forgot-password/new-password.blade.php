@extends('layout.default')

@section('title', 'Reset Password')
@section('screen-name', 'login-screen')

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Reset Password</h4></div>
                <div class="panel-body">

                    @include('commons.errors')

                    <form action="{{ url('forgot-password/reset') }}" method="post">
                        {{ csrf_field() }}

                        <h5>Please enter your new password.</h5>

                        <div class="form-group form-group-lg">
                            <input id="new_password" class="form-control" type="password" name="new_password" value="{{ v('new_password') }}" placeholder="New Password">
                        </div>

                        <div class="form-group form-group-lg">
                            <input id="new_password_confirmation" class="form-control" type="password" name="new_password_confirmation" value="{{ v('new_password_confirmation') }}" placeholder="Retype Password">
                        </div>

                        <h6>Please reset your password in the next {{$password->otpPasswordTimeRemainingValid()}}.</h6>

                        <div class="form-group form-group-lg reset-password-btn">
                            <button class="btn btn-primary btn-block btn-lg">Reset Password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
