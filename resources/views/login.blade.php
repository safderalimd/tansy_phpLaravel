@extends('layout.default')

@section('title', 'Login to tansyCloud')
@section('screen-name', 'login-screen')

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Login to tansyCloud</h4></div>
                <div class="panel-body">

                    @include('commons.errors')

                    @if(Session::has('login-message'))
                        <div class="alert alert-info">
                            <ul><li>{{ Session::get('login-message') }}</li></ul>
                        </div>
                    @endif

                    <form action="{{ url('login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group form-group-lg">
                            <input class="form-control input-lg" id="inputLogin" name="login" value="{!!old('login')!!}" placeholder="Login">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-group-lg">
                            <input type="password" class="form-control input-lg" name="password" id="inputPassword" value="{!!old('password')!!}" placeholder="Password">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-group-lg">
                            <button class="btn btn-primary btn-block btn-lg">Login</button>
                        </div>

                        <div class="form-group form-group-lg" style="margin-bottom: 0;">
                            <div class="row">
                                {{--
                                <div class="col-xs-6">
                                    <div class="checkbox">
                                        <label>
                                            @if (Cookie::get('remember'))
                                                <input type="checkbox" name="remember" checked="checked" value="1">
                                            @else
                                                <input type="checkbox" name="remember" value="1">
                                            @endif
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                --}}
                                <div class="col-xs-6 col-xs-offset-6 text-right">
                                    <div style="padding-top: 10px"><a href="/forgot-password">Forgot Password?</a></div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
