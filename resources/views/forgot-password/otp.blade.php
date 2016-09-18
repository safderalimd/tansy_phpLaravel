@extends('layout.default')

@section('title', 'Forgot Password OTP')
@section('screen-name', 'login-screen')

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Forgot Password OTP</h4></div>
                <div class="panel-body">

                    @include('commons.errors')

                    <form action="{{ url('forgot-password/otp') }}" method="post">
                        {{ csrf_field() }}

                        <h5>Note: You will receive an SMS with the OTP code.</h5>

                        <div class="form-group form-group-lg">
                            <input class="form-control" name="otp_code" value="{!!old('otp_code')!!}" placeholder="Username">
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group form-group-lg reset-password-btn">
                            <button class="btn btn-primary btn-block btn-lg">Check OTP</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
