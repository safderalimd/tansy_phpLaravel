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

                    @if (force_change_password())
                        <div class="alert alert-success">
                            <ul><li>For security reasons, you need to change your password.</li></ul>
                        </div>
                    @endif

                    <form id="change-password-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="old_password">Current Password</label>
                            <div class="col-md-8">
                                <input id="old_password" class="form-control" type="password" name="old_password" value="{{ v('old_password') }}" placeholder="Current Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="new_password">New Password</label>
                            <div class="col-md-8">
                                <input id="new_password" class="form-control" type="password" name="new_password" value="{{ v('new_password') }}" placeholder="New Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="new_password_confirmation">Retype Password</label>
                            <div class="col-md-8">
                                <input id="new_password_confirmation" class="form-control" type="password" name="new_password_confirmation" value="{{ v('new_password_confirmation') }}" placeholder="Retype Password">
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-offset-4 col-md-8">
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


@section('scripts')
<script type="text/javascript">

    $('#change-password-form').validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                minlength: 8,
                notEqualTo: "#old_password"
            },
            new_password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#new_password",
                notEqualTo: "#old_password"
            }
        },
        messages: {
            new_password: {
                notEqualTo: "Your new password must be different than your old password."
            },
            new_password_confirmation: {
                notEqualTo: "Your new password must be different than your old password."
            }
        }
    });

</script>
@endsection
