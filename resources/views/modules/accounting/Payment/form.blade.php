@extends('layout.cabinet')

@section('title', 'Payment')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Payment</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

<form class="form-horizontal" action="/cabinet/payment/pay-now" id="pay-now-form" method="POST">
    {{ csrf_field() }}

    <?php
        $allRows = $payment->rows();
        if (count($allRows)) {
            $accountName = $allRows[0]['account_name'];
        } else {
            $accountName = '-';
            $allRows = [];
        }
    ?>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Total Due</th>
                        <th>New Balance</th>
                        <th>Paid Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><div style="padding-top:10px;">{{$accountName}}</div></td>
                        <td>
                            <div style="background-color:#fff;" data-totaldue="{{ $payment->totalDue }}" id="total-due" class="well well-sm">{{ $payment->totalDue }}</div>
                        </td>
                        <td>
                            <div style="background-color:#fff;min-width:93px;" id="new-balance" class="well well-sm">{{ $payment->totalDue }}</div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-12">
                                    <input style="height:40px;" id="paid-amount" class="form-control" type="text" name="paid_amount" value="{{ v('paid_amount') }}" disabled="disabled" placeholder="Paid Amount">
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
       <div class="col-md-6 col-md-offset-3 text-center grid_footer">
            <button class="btn btn-success btn-block btn-lg grid_btn" id="pay-now-btn" type="submit">Pay Now</button>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-striped">
                @foreach($allRows as $row)
                    <tr>
                        <td><input type="checkbox" data-scheduleentityid="{{ $row['schedule_entity_id'] }}" data-dateid="{{ $row['date_id'] }}" data-totalamount="{{ $row['total_amount'] }}" data-dueamount="{{ $row['due_amount'] }}" class="detail-row" name="paid-amount-checkbox" value=""></td>
                        <td>{{ $row['product_name'] }} - {{ $row['schedule_name'] }} ({{$row['current_schedule_name']}})</td>
                        <td>{{ $row['due_amount'] }}</td>
                    </tr>
                @endforeach
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

    $('#pay-now-form').submit(function() {
        $('#pay-now-btn').prop('disabled',true);
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
        return parseFloat(paidAmount);
    }

    // get the new balance
    function getNewBalance() {
        var totalDue = getTotalDue();
        var paidAmount = getPaidAmount();
        return totalDue - paidAmount;
    }

    // update the new balance box
    function updateNewBalance() {
        $('#new-balance').text(getNewBalance());
    }

    // update paid amount with value of selected rows
    function updatePaidAmount() {
        $('#paid-amount').val(getDetailRowsDueAmount());
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

    // when changing a checkbox value
    $('.detail-row').change(function() {
        updatePaidAmount();
        updateNewBalance();
        if (canEditPaidAmount()) {
            $('#paid-amount').prop('disabled', false);
        } else {
            $('#paid-amount').prop('disabled', true);
        }
    });

    // when changing the paid amount text input
    $('#paid-amount').change(function() {
        updateNewBalance();
    });

</script>
@endsection
