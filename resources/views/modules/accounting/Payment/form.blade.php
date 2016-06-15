@extends('layout.cabinet')

@section('title', 'Payment')

@section('content')

<?php
    $allRows = $payment->rows();
    $phoneNumber = null;
    if (count($allRows)) {
        $accountName = $allRows[0]['account_name'];
        $phoneNumber = $allRows[0]['mobile_phone'];
    } else {
        $accountName = '-';
        $allRows = [];
    }

    $isCashCounterClosed = $payment->isCashCounterClosed();
?>

<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-th"></i>
                <h3>Payment for {{$accountName}}</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                @if ($isCashCounterClosed)
                    <div class="alert alert-danger">
                        <ul><li>The cash counter is closed!</li></ul>
                    </div>
                @endif

<form class="form-horizontal" action="{{ form_action_full() }}" id="pay-now-form" method="POST">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div data-totaldue="{{ $payment->totalDue }}" id="total-due" style="margin-bottom:0px;" class="well well-sm">{{ number_format($payment->totalDue, 2) }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><h4><strong>Total Due</strong></h4></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="new-balance" style="margin-bottom:0px;" class="well well-sm">{{ number_format($payment->totalDue, 2) }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><h4><strong>New Balance</strong></h4></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <input style="height:40px;" id="paid-amount" class="form-control" type="text" name="paid_amount" value="{{ v('paid_amount') }}" disabled="disabled" placeholder="Paid Amount">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><h4><strong>Paid Amount</strong></h4></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
       <div class="col-md-6 col-md-offset-3 text-center">
            <button style="margin:15px;" disabled="disabled" @if ($isCashCounterClosed) data-cashCounterClosed="1" @endif class="btn btn-primary btn-block btn-lg" id="pay-now-btn" type="submit">Pay Now</button>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-striped">
                @foreach($allRows as $row)
                    <tr>
                        <td class="text-left">
                            <label class="checkbox-inline">
                                <input type="checkbox" data-scheduleentityid="{{ $row['schedule_entity_id'] }}" data-dateid="{{ $row['date_id'] }}" data-totalamount="{{ $row['total_amount'] }}" data-dueamount="{{ $row['due_amount'] }}" class="detail-row" name="paid-amount-checkbox" value="">
                                {{ $row['product_name'] }} - {{ $row['schedule_name'] }} ({{$row['current_schedule_name']}})
                            </label>
                        </td>
                        <td>{{ number_format($row['due_amount'], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        <div class="checkbox">
                            <label class="checkbox-inline" style="margin-top: 25px; margin-bottom: 10px;">
                                @if (empty($phoneNumber))
                                    <input type="checkbox" disabled="disabled" name="send_receipt_sms">
                                @else
                                    @if ($payment->shouldSendReceiptSms())
                                        <input type="checkbox" name="send_receipt_sms" checked="checked">
                                    @else
                                        <input type="checkbox" name="send_receipt_sms">
                                    @endif
                                @endif

                                <h5 style="margin:2px;"><small>Send Receipt SMS ({{phone_number($phoneNumber)}})</small></h5>

                            </label>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>

    <input type="hidden" name="new_balance" id="id_new_balance" value="">
    <input type="hidden" name="credited_to_entity_id" id="id_credited_to_entity_id" value="{{ $primaryKey }}">
    <input type="hidden" name="schEntID_dateID_schAmnt_PaidAmnt_list" id="id_schEntID_dateID_schAmnt_PaidAmnt_list" value="">
    <input type="hidden" name="total_paid_amount" id="id_total_paid_amount" value="">

</form>

                </section>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">

    function enablePayNowButton() {
        if ($('#pay-now-btn').attr('data-cashCounterClosed') == '1') {
            return;
        }
        $('#pay-now-btn').prop('disabled', false);
    }

    $('#pay-now-form').submit(function() {
        $('#pay-now-btn').prop('disabled', true);
        $('#id_new_balance').val(getNewBalance());

        var ids = $('.detail-row:checked').map(function() {
            var scheduleentityid = $(this).attr('data-scheduleentityid');
            var dateid = $(this).attr('data-dateid');
            var totalamount = $(this).attr('data-totalamount');
            var dueamount = $(this).attr('data-dueamount');
            return scheduleentityid + "-" + dateid + "-" + totalamount + "-" + dueamount;
        }).get();

        $('#id_schEntID_dateID_schAmnt_PaidAmnt_list').val(ids.join(','));

        $('#id_total_paid_amount').val(getPaidAmount());

        return true;
    });

    // get the total due from the first box
    function getTotalDue() {
        var totalDue = $('#total-due').attr('data-totaldue');
        return parseFloat(totalDue);
    }

    // get the paid amount from the text input
    function getPaidAmount() {
        var paidAmount = $('#paid-amount').val();
        paidAmount = paidAmount.replace(/,/g , '');
        paidAmount = parseFloat(paidAmount);
        if (isNaN(paidAmount)) {
            paidAmount = 0.00;
        }
        return paidAmount;
    }

    // get the new balance
    function getNewBalance() {
        var totalDue = getTotalDue();
        var paidAmount = getPaidAmount();
        var newBalance = totalDue - paidAmount;
        return parseFloat(Math.round(newBalance * 100) / 100).toFixed(2);
    }

    // update the new balance box
    function updateNewBalance() {
        var newBalance = getNewBalance();
        if (newBalance < 0) {
            $('#pay-now-btn').prop('disabled', true);
        } else {
            enablePayNowButton();
        }
        $('#new-balance').text(addCommas(newBalance));
    }

    // update paid amount with value of selected rows
    function updatePaidAmount() {
        var paidAmount = getDetailRowsDueAmount();
        paidAmount = parseFloat(Math.round(paidAmount * 100) / 100).toFixed(2);
        $('#paid-amount').val(addCommas(paidAmount));
    }

    // check if only one checkbox is selected
    function canEditPaidAmount() {
        return $('.detail-row:checked').length == 1;
    }

    // sum from all detail rows that are checked
    function getDetailRowsDueAmount() {
        var dueAmounts = $('.detail-row:checked').map(function() {
            return $(this).attr('data-dueamount');
        }).get();

        var total = 0;
        for (var i = 0; i < dueAmounts.length; i++) {
            total += parseFloat(dueAmounts[i]);
        }
        return total;
    }

    function updatePaymentButton() {
        var paidAmount = getPaidAmount();
        if (paidAmount <= 0) {
            $('#pay-now-btn').prop('disabled', true);
        } else {
            enablePayNowButton()
        }
    }

    // when changing a checkbox value
    $('.detail-row').change(function() {
        updatePaidAmount();
        updateNewBalance();
        if (canEditPaidAmount()) {
            $('#paid-amount').prop('disabled', false);
        } else {
            $('#paid-amount').prop('disabled', true);
        }
        updatePaymentButton();
    });

    // when changing the paid amount text input
    $('#paid-amount').change(function() {
        updateNewBalance();
        updatePaymentButton();
    });
    $('#paid-amount').keyup(function() {
        updateNewBalance();
        updatePaymentButton();
    });

    // format numbers
    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '.00';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

</script>
@endsection
