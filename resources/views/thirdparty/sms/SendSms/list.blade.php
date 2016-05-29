@extends('layout.cabinet')

@section('title', 'Send SMS')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Send SMS</h3>
        </div>
        <div class="panel-body">

        @include('commons.errors')

        <form class="form-horizontal" action="" method="POST">
            <div class="form-group">
                <label class="col-md-1 control-label" for="sms_type_id">SMS Type</label>
                <div class="col-md-2">
                    <select id="sms_type_id" class="form-control" name="sms_type_id">
                        <option value="none">Select a sms type</option>
                        @foreach($sms->smsTypes as $option)
                            <option {{ activeSelect($option['sms_type_id'], 'sti') }} value="{{ $option['sms_type_id'] }}">{{ $option['sms_type'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-md-offset-6">
                    <h4 class="text-right">SMS Balance:</h4>
                </div>
                <div class="col-md-1">
                    <h4 class="text-left"><strong id="sms-balance-count" data-balance="{{$sms->smsBalanceCount}}" >{{nr($sms->smsBalanceCount)}}</strong></h4>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-1 control-label" for="sms_account_entity_id">Filter Accounts</label>
                <div class="col-md-2">
                    <select id="sms_account_entity_id" class="form-control" name="sms_account_entity_id">
                        <option value="none">Select an account</option>
                        @foreach($sms->smsAccountTypes as $option)
                            <option data-rowType="{{$option['row_type']}}" {{ activeSelect($option['entity_id'], 'aei') }} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-md-offset-6">
                    <h4 class="text-right">Current Selected:</h4>
                </div>
                <div class="col-md-1">
                    <h4 class="text-left"><strong id="current-selected">0</strong></h4>
                </div>
            </div>

            <div id="exam-container" style="display:none;" class="form-group">
                <label class="col-md-1 control-label" for="exam_entity_id">Exam Name</label>
                <div class="col-md-2">
                    <select id="exam_entity_id" class="form-control" name="exam_entity_id">
                        <option value="none">Select an exam</option>
                        @foreach($sms->exam as $option)
                            <option {{ activeSelect($option['exam_entity_id'], 'eei') }} value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
                        @endforeach
                    </select>
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
                    <td>
                        {{$row['account_name']}}
                    </td>
                    <td>
                        {{phone_number($row['mobile_phone'])}}
                    </td>
                    <td>
                        @if (isset($row['due_amount']))
                            Your current due is {{amount($row['due_amount'])}}.
                        @elseif (isset($row['sms_text']))
                            {{$row['sms_text']}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br/>

        <table style="width:100%;">
            <tr>
                <td style="width:200px;">
                    <div class="checkbox text-center">
                        <label style="margin-bottom:10px;"><input disabled="disabled" type="checkbox" id="common-sms-checkbox" name="common-sms" value="">Common SMS Text:</label>
                    </div>
                </td>
                <td>
                    <textarea maxlength="160" disabled="disabled" id="sms-message" class="form-control" rows="4"></textarea>
                    <span class="pull-right text-muted"><span id="total-chars-used">160</span> used out of 160 characters</span>
                </td>
            </tr>
        </table>

        <br/>

        <nav class="nav-footer navbar navbar-default">
            <div class="container-fluid">
                <form class="navbar-form navbar-right" id="send-sms-form" action="{{form_action_full()}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_ids" id="student_ids" value="">
                    <input type="hidden" name="common_message" id="common_message" value="">

                    <a class="btn btn-default" href="/cabinet/send-sms">Cancel</a>
                    <button disabled="disabled" id="send-sms-button" type="submit" class="btn btn-primary">Send Sms</button>
                </form>
            </div>
        </nav>

        @include('commons.modal')

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    updateSendButton();
    updateCommonSms();

    // create datatale with checkbox column unsortable
    $('#sms-table').DataTable( {
       "aoColumnDefs": [
           { 'bSortable': false, 'aTargets': [ 0 ] }
        ],
        "bPaginate": false
    });

    // max nr of charachters counter for text area
    $('#sms-message').keyup(function() {
        var textLength = $('#sms-message').val().length;
        var textRemaining = 160 - textLength;
        $('#total-chars-used').text(textRemaining);
    });

    // when the sms type dropdown changes redirect
    $('#sms_type_id').change(function() {
        if (examResultsIsSelected()) {
            updateQueryString();
        } else {
            updateQueryString(true);
        }
    });

    // when the sms account type dropdown changes redirect
    $('#sms_account_entity_id').change(function() {
        updateQueryString();
    });

    // when the exam dropdown changes redirect
    $('#exam_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString(skipExamId) {
        window.location.href = "/cabinet/send-sms" + getQueryString(skipExamId);
    }

    // get teh query string depending on which selectboxes are set
    function getQueryString(skipExamId) {
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
        if (!skipExamId && eei != "none") {
            items.push('eei='+eei);
        }
        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    function examResultsIsSelected() {
        var text = $('#sms_type_id option:selected').text();
        text = text.trim();
        text = text.toLowerCase();
        return (text.indexOf("exam result") > -1);
    }

    // enable exam dropdown only if sms type is 'Exam Result'
    $(document).ready(function() {
        if (examResultsIsSelected()) {
            $('#exam-container').show();
        }
    });

    function updateSendButton() {
        if (canSendSms()) {
            $('#send-sms-button').prop('disabled', false);
        } else {
            $('#send-sms-button').prop('disabled', true);
        }
    }

    function updateCommonSms() {
        if (canUseCommmonSms()) {
            $('#sms-message').prop('disabled', false);
            $('#common-sms-checkbox').prop('checked', true);
        } else {
            $('#sms-message').prop('disabled', true);
            $('#common-sms-checkbox').prop('checked', false);
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
        return true;
    }

    function canUseCommmonSms() {
        var text = $('#sms_type_id option:selected').text();
        text = text.trim();
        text = text.toLowerCase();
        if (text == 'exam result' || text == 'fee reminder') {
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
</script>
@endsection
