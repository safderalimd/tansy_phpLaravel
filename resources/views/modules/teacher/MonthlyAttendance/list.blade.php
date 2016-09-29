@extends('layout.cabinet')

@section('title', 'Monthly Attendance')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Monthly Attendance</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="month_id">Month</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="month_id" class="form-control" name="mi">
                            <option value="none">Select a month..</option>
                            @foreach($attendance->months() as $option)
                                <option {{activeSelect($option['month_id'], 'mi')}} value="{{ $option['month_id'] }}">{{ $option['calendar_month'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label" for="account_type_entity_id">Class</label>
                    <div class="col-sm-3 col-md-3">
                        <select id="account_type_entity_id" class="form-control" name="aei">
                            <option value="none">Select a class..</option>
                            @foreach($attendance->classes() as $option)
                                <option {{activeSelect($option['class_entity_id'], 'aei')}} value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-6">
                    <form id="attendance-table-form">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Student Name</th>
                                <th>Days Present</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>
                            @foreach($attendance->rows() as $row)
                                <tr>
                                    <td>{{$row['student_roll_number']}}</td>
                                    <td>{{$row['account_name']}}</td>
                                    <td>
                                        <input data-rule-number="true" data-rule-min="0"  type="text" autocomplete="off" value="{{$row['presence_count']}}" class="row_account_entity_id form-control" name="{{$i++}}row_account_entity_id" data-accountId="{{$row['account_entity_id']}}" >
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>

            <br/>

            <div class="row">
                <div class="col-md-6">
                    <form class="form-horizontal" id="update-attendance-form" action="{{form_action_full()}}" method="POST">
                        {{ csrf_field() }}

                        <input type="hidden" name="actEntID_presenceDays" id="actEntID_presenceDays" value="">

                        <div class="row">
                            <div class="form-horizontal">
                                <div class="col-md-4 pull-right">
                                    <input required data-rule-number="true" data-rule-min="0" type="text" id="working_days_count" class="form-control pull-right" name="working_days_count">
                                </div>
                                <label class="pull-right control-label" for="working_days_count">Working Days Count</label>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 15px;">
                           <div class="col-md-12">
                                <a href="{{ url("/cabinet/monthly-attendance")}}" class="pull-right btn btn-default cancle_btn">Cancel</a>
                                <button type="submit" class="pull-right btn btn-primary" style="margin-right: 10px;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('commons.modal')

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    // when the account types dropdown changes redirect
    $('#account_type_entity_id, #month_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var aei = $('#account_type_entity_id option:selected').val();
        var mi = $('#month_id option:selected').val();

        var items = [];
        if (aei != "none") {
            items.push('aei='+aei);
        }
        if (mi != "none") {
            items.push('mi='+mi);
        }
        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    $('#update-attendance-form').submit(function() {
        if (! $('#update-attendance-form').valid()) {
            return false;
        }

        var accountIds = $('.row_account_entity_id').map(function() {
            var accountId = $(this).attr('data-accountId');

            var presentDays = this.value;
            if (presentDays !== 0 && !presentDays) {
                presentDays = 'null';
            }

            return accountId + '-' + presentDays;
        }).get();

        $('#actEntID_presenceDays').val(accountIds.join('|'));

        return true;
    });

    $('#update-attendance-form').validate();
    $('#attendance-table-form').validate();

</script>
@endsection
