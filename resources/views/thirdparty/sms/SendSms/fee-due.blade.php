@extends('layout.cabinet')

@section('title', 'Send Fee Due SMS')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Send Fee Due SMS</h3>
        </div>
        <div class="panel-body">

        @include('commons.errors')
        @include('commons.sms-inactive')

        <form class="form-horizontal" action="" method="POST">
            <div class="form-group">
                <label class="col-xs-3 col-md-1 control-label" for="sms_account_entity_id">Filter Accounts</label>
                <div class="col-xs-9 col-md-3">
                    <select id="sms_account_entity_id" class="form-control" name="sms_account_entity_id">
                        <option value="none">Select an account..</option>
                        @foreach($sms->smsAccountTypes as $option)
                            <option data-rowType="{{$option['row_type']}}" {{ activeSelect($option['entity_id'], 'aei') }} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-4 col-xs-offset-0 col-sm-10 col-md-3 col-md-offset-4">
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
                        @if (empty($row['mobile_phone']))
                            <input disabled="disabled" type="checkbox" data-id="{{$row['account_entity_id']}}" class="account-entity-id" name="account_entity_id" value="">
                        @else
                            <input type="checkbox" data-id="{{$row['account_entity_id']}}" class="account-entity-id" name="account_entity_id" value="{{$row['account_entity_id']}}">
                        @endif
                    </td>
                    <td>{{$row['account_name']}}</td>
                    <td>{{phone_number($row['mobile_phone'])}}</td>
                    <td>Your current fee due amount is {{amount($row['due_amount'])}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br/>

        <nav class="nav-footer navbar navbar-default">
            <div class="container-fluid">
                <form class="navbar-form navbar-right" id="send-sms-form" action="{{form_action_full()}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_ids" id="student_ids" value="">

                    <a class="btn btn-default" href="/cabinet/send-sms---fee-due">Cancel</a>
                    <a class="btn btn-success" target="_blank" href="/cabinet/send-sms---fee-due/csv{{query_string()}}">Export CSV</a>
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

    updateSendButton();

    // create datatale with checkbox column unsortable
    $('#sms-table').DataTable( {
       "aoColumnDefs": [
           { 'bSortable': false, 'aTargets': [ 0 ] }
        ],
        "bPaginate": false,
        "autoWidth": false
    });

    // max nr of charachters counter for text area
    $('#sms-message').keyup(function() {
        var textLength = $('#sms-message').val().length;
        var textRemaining = 145 - textLength;
        $('#total-chars-used').text(textRemaining);
    });

    // when the sms account type dropdown changes redirect
    $('#sms_account_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get teh query string depending on which selectboxes are set
    function getQueryString() {
        var aei = $('#sms_account_entity_id option:selected').val();
        var art = $('#sms_account_entity_id option:selected').attr('data-rowType');

        var items = [];
        if (aei != "none") {
            items.push('aei='+aei);
            items.push('art='+encodeURIComponent(art));
        }
        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

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
            $('.account-entity-id').each(function() { if(this.value) {$(this).prop('checked', true);} });
        } else {
            $('.account-entity-id').prop('checked', false);
        }
        updateCurrentSelected();
    });

    $('#send-sms-form').submit(function() {

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
