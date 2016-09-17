@extends('layout.default')

@section('title', 'Forgot Password')

@section('styles')
    <style>
        html > body { background-color: #404040; }
        .login-wrapper { padding-top: 50px; }
        footer { color: #fff }
        .reset-password-btn {
            margin-top: 15px;
        }
    </style>

    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Forgot Password</h4></div>
                <div class="panel-body">

                    @include('commons.errors')

                    <form action="{{ url('forgot-password') }}" method="post">
                        {{ csrf_field() }}

                        <h5>Note: You will get only one chance to provide correct information.</h5>

                        <div class="form-group form-group-lg">
                            <input class="form-control" name="login_username" value="{!!old('login_username')!!}" placeholder="Username">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-group-lg">
                            <input type="text" class="form-control" name="mobile_phone" value="{!!old('mobile_phone')!!}" placeholder="Mobile Phone">
                            <span class="help-block"></span>
                        </div>

                        <div class="g-recaptcha" data-sitekey="6LeTAAcUAAAAAF2K6Yj_keMTQNjqsvmywR1I2HT6"></div>

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
