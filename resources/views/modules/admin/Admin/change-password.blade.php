@extends('layout.cabinet')

@section('title', 'Change Password')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Change Password</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="old_password">Current Password</label>
                            <div class="col-md-8">
                                <input id="old_password" class="form-control" type="password" name="old_password" value="{{ v('old_password') }}" placeholder="Current Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="new_password">New Password</label>
                            <div class="col-md-8">
                                <input id="new_password" class="form-control" type="password" name="new_password" value="{{ v('new_password') }}" placeholder="New Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="new_password_confirmation">Retype Password</label>
                            <div class="col-md-8">
                                <input id="new_password_confirmation" class="form-control" type="password" name="new_password_confirmation" value="{{ v('new_password_confirmation') }}" placeholder="Retype Password">
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
