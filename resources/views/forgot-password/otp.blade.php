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

                    @if(Session::has('otp-resent'))
                        <div class="alert alert-info">
                            <ul><li>{{ Session::get('otp-resent') }}</li></ul>
                        </div>
                    @endif

                    <form action="{{ url('forgot-password/otp') }}" method="post">
                        {{ csrf_field() }}

                        <h5>Please enter the OTP code you will receive in the SMS.</h5>

                        <div style="margin-bottom:0px;" class="form-group form-group-lg">
                            <input class="form-control" name="otp_code" value="{!!old('otp_code')!!}" placeholder="OTP">
                        </div>
                        <h6>The OTP code will expire in {{$password->otpTimeRemainingValid()}}.</h6>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <div><a href="/forgot-password/otp-resend">Resend SMS?</a></div>
                            </div>
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
