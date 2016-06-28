@extends('layout.cabinet')

@section('title', 'Send General SMS')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Send General SMS</h3>
        </div>
        <div class="panel-body">

        @include('commons.errors')

        <form class="form-horizontal" action="" method="POST">
            <div class="form-group">
                <label class="col-xs-3 col-md-2 control-label" for="sms_type_id">SMS Type</label>
                <div class="col-xs-9 col-md-3">
                    <select id="sms_type_id" class="form-control" name="sms_type_id">
                        <option value="none">Select a sms type..</option>
                        @foreach($sms->generalSmsTypes as $option)
                            <option {{ activeSelect($option['sms_type_id'], 'sti') }} value="{{ $option['sms_type_id'] }}">{{ $option['sms_type'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-4 col-xs-offset-0 col-sm-10 col-md-3 col-md-offset-3">
                    <h4 class="text-right">SMS Balance:</h4>
                </div>
                <div class="col-xs-5 col-sm-2 col-md-1">
                    <h4 class="text-left"><strong id="sms-balance-count" data-balance="{{$sms->smsBalanceCount}}" >{{nr($sms->smsBalanceCount)}}</strong></h4>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-3 col-md-2 control-label" for="sms_account_entity_id">Filter Accounts</label>
                <div class="col-xs-9 col-md-3">
                    <select id="sms_account_entity_id" class="form-control" name="sms_account_entity_id">
                        <option value="none">Select an account..</option>
                        @foreach($sms->smsAccountTypes as $option)
                            <option data-rowType="{{$option['row_type']}}" {{activeSelectByTwo($option['entity_id'], $option['row_type'], 'aei', 'art')}} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-4 col-xs-offset-0 col-sm-10 col-md-3 col-md-offset-3">
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
                </tr>
            </thead>
            <tbody>
                @foreach($sms->rows() as $row)
                <tr>
                    <td class="text-center">
                        @if (empty($row['mobile_phone'])))
                            <input disabled="disabled" type="checkbox" data-id="{{$row['account_entity_id']}}" class="account-entity-id" name="account_entity_id" value="">
                        @else
                            <input type="checkbox" data-id="{{$row['account_entity_id']}}" class="account-entity-id" name="account_entity_id" value="{{$row['account_entity_id']}}">
                        @endif
                    </td>
                    <td>
                        {{$row['account_name']}}
                    </td>
                    <td>
                        {{phone_number($row['mobile_phone'])}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br/>

        <div class="row">
            <div class="col-md-12">
                <form id="sms-textarea-form" class="form-horizontal" action="" method="POST">
                    <textarea maxlength="160" name="sms_common_message" id="sms-message" class="form-control" rows="4"></textarea>
                    <span class="pull-right text-muted"><span id="total-chars-used">160</span> used out of 160 characters</span>
                </form>
            </div>
        </div>

        <br/>

        <nav class="nav-footer navbar navbar-default">
            <div class="container-fluid">
                <form class="navbar-form navbar-right" id="send-sms-form" action="{{form_action_full()}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_ids" id="student_ids" value="">
                    <input type="hidden" name="common_message" id="common_message" value="">

                    <a class="btn btn-default" href="/cabinet/send-sms---general">Cancel</a>
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
        var textRemaining = 160 - textLength;
        $('#total-chars-used').text(textRemaining);
    });

    // when the sms type dropdown changes redirect
    $('#sms_type_id').change(function() {
        updateQueryString();
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
        var sti = $('#sms_type_id option:selected').val();
        var aei = $('#sms_account_entity_id option:selected').val();
        var art = $('#sms_account_entity_id option:selected').attr('data-rowType');
        var eei = $('#exam_entity_id option:selected').val();

        var items = [];
        if (sti != "none") {
            items.push('sti='+sti);
        }
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
        if (! $('#sms-textarea-form').valid()) {
            return false;
        }

        var message = $('#sms-message').val();
        $('#common_message').val(message);

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

    $('#sms-textarea-form').validate({
        rules: {
            sms_common_message: {
                required: true
            }
        }
    });

</script>
@endsection
