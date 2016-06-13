@extends('layout.cabinet')

@section('title', 'Send Attendance SMS')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Send Attendance SMS</h3>
        </div>
        <div class="panel-body">

        @include('commons.errors')

        <form class="form-horizontal" action="{{form_action_full()}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-xs-3 col-md-1 control-label" for="">Date</label>
                <div class="col-xs-5 col-md-2">
                    <div class="input-group date">
                        <input id="absense_date" class="form-control" type="text" name="absense_date" value="{{$sms->absense_date}}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                        </span>
                    </div>
                </div>
                <div class="col-xs-4 col-md-2">
                    <button id="update-date" type="submit" class="btn btn-primary">Update Results</button>
                </div>

                <div class="col-xs-4 col-xs-offset-0 col-sm-10 col-md-3 col-md-offset-3">
                    <h4 class="text-right">SMS Balance:</h4>
                </div>
                <div class="col-xs-5 col-sm-2 col-md-1">
                    <h4 class="text-left"><strong id="sms-balance-count" data-balance="{{$sms->smsBalanceCount}}" >{{nr($sms->smsBalanceCount)}}</strong></h4>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-4 col-xs-offset-0 col-sm-10 col-md-3 col-md-offset-8">
                    <h4 class="text-right">Current Selected:</h4>
                </div>
                <div class="col-xs-5 col-sm-2 col-md-1">
                    <h4 class="text-left"><strong id="current-selected">0</strong></h4>
                </div>
            </div>
        </form>

        <table id="sms-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                    <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Mobile <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>SMS Text <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sms->rows() as $row)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" data-id="{{$row['account_entity_id']}}" class="account-entity-id" name="account_entity_id" value="{{$row['account_entity_id']}}">
                    </td>
                    <td>{{$row['account_name']}}</td>
                    <td>{{phone_number($row['mobile_phone'])}}</td>
                    <td>{{$row['sms_text']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br/>

        <nav class="nav-footer navbar navbar-default">
            <div class="container-fluid">
                <form class="navbar-form navbar-right" id="send-sms-form" action="/cabinet/send-sms---attendence/send" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_ids" id="student_ids" value="">
                    <input type="hidden" name="hidden_absense_date" id="hidden_absense_date" value="">

                    <a class="btn btn-default" href="/cabinet/send-sms---attendence">Cancel</a>
                    <button disabled="disabled" id="send-sms-button" type="submit" class="btn btn-primary">Send Sms</button>
                </form>
            </div>
        </nav>

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    // create datatale with checkbox column unsortable
    $('#sms-table').DataTable( {
       "aoColumnDefs": [
           { 'bSortable': false, 'aTargets': [ 0 ] }
        ],
        "bPaginate": false
    });

    function updateSendButton() {
        if (canSendSms()) {
            $('#send-sms-button').prop('disabled', false);
        } else {
            $('#send-sms-button').prop('disabled', true);
        }
    }

    function updateCurrentSelected() {
        var nr = $('.account-entity-id:checked').length;
        $('#current-selected').text(nr);
        updateSendButton();
    }

    function canSendSms() {
        var balance = $('#sms-balance-count').attr('data-balance');
        balance = parseInt(balance);
        var currentSelected = $('.account-entity-id:checked').length;
        if (balance == 0 || currentSelected > balance) {
            return false;
        }
        if (currentSelected <= 0) {
            return false;
        }
        return true;
    }

    // update current selected
    $('.account-entity-id').change(function() {
        updateCurrentSelected();
    });

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.account-entity-id').prop('checked', true)
        } else {
            $('.account-entity-id').prop('checked', false);
        }
        updateCurrentSelected();
    });

    $('#send-sms-form').submit(function() {
        var date = $('#absense_date').val();
        $('#hidden_absense_date').val(date);

        var accountIds = $('.account-entity-id:checked').map(function() {
            return this.value;
        }).get();

        if (accountIds.length == 0) {
            alert("No accounts are selected.");
            return false;
        }

        $('#student_ids').val(accountIds.join(','));

        return true;
    });
</script>
@endsection
