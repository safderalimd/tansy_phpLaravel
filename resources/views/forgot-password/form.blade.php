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
        @media screen and (max-width: 450px){
            .g-recaptcha {
                transform:scale(0.77);
                -webkit-transform:scale(0.77);
                transform-origin:0 0;
                -webkit-transform-origin:0 0;
            }
            .reset-password-btn {
                margin-top: 0px;
            }
        }
        @media screen and (max-width: 360px){
            .g-recaptcha {
                transform:scale(0.65);
                -webkit-transform:scale(0.65);
                transform-origin:0 0;
                -webkit-transform-origin:0 0;
            }
        }
    </style>
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
                            <input class="form-control" name="login_field" value="{!!old('login_field')!!}" placeholder="Username">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-group-lg">
                            <input type="text" class="form-control" name="mobile_phone" value="{!!old('mobile_phone')!!}" placeholder="Mobile Phone">
                            <span class="help-block"></span>
                        </div>

                        {!! app('captcha')->display(); !!}

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
