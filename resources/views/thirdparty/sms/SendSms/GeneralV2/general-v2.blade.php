@extends('layout.cabinet')

@section('title', 'Send SMS v2')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Send SMS v2</h3>
        </div>
        <div class="panel-body">

        @include('commons.errors')



        <table id="sms-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                    <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Mobile <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>City <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sms->rows() as $row)
                <tr class="account-row">
                    <td class="text-center">
                        @if (empty($row['mobile_phone']))
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
                    <td>
                        {{$row['city_name']}}
                    </td>
                    <td>
                        <textarea @if (empty($row['mobile_phone'])) disabled="disabled" @endif style="width:100%;" rows="2" maxlength="160" name="" class="custom-message-text form-control"></textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br/>

        <nav class="nav-footer navbar navbar-default">
            <div class="container-fluid">
                <form class="navbar-form navbar-right" id="send-sms-form" action="{{form_action_full()}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="text_messages" id="text-messages" value="">

                    <a class="btn btn-default" href="/cabinet/send-sms-v2">Cancel</a>
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

        var messages = [];
        var accountIds = $('.account-entity-id:checked').each(function() {
            var currentRow = $(this).closest('.account-row');
            var id = this.value;
            var message = $('.custom-message-text', currentRow).val();
            messages.push({id: id, message: message});
        });

        if (messages.length == 0) {
            alert("No accounts are selected.");
            return false;
        }

        $('#text-messages').val(JSON.stringify(messages));

        return true;
    });

</script>
@endsection
