@extends('layout.cabinet')

@section('title', 'Payment')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Payment v1</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                    <form class="form-horizontal" action="" method="POST">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-8">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="exam_account_type_4_receivable_id">Account Type</label>
                                    <div class="col-md-8">
                                        <select id="exam_account_type_4_receivable_id" class="form-control" name="exam_account_type_4_receivable_id">
                                            <option data-rowtype="none" value="none">Select an account..</option>
                                            <?php $accountType = 'Account Type'; ?>
                                            @foreach($payment->accountTypeFilter() as $option)
                                                <?php
                                                    if ($accountKey == $option['entity_id']) {
                                                        $accountType = $option['drop_down_list_name'];
                                                    }
                                                ?>
                                                <option {{activeSelectByTwo($option['entity_id'], $option['row_type'], 'ak', 'rt')}} data-rowtype="{{$option['row_type']}}"  value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Account Type <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Due <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

@if (count($payment->rows()))
    @foreach($payment->rows() as $row)
    <tr>
        <td style="width:160px;">{{$accountType}}</td>
        <td>{{$row['account_name']}}</td>
        @if (isset($row['2']))
            <td>&#x20b9; {{amount($row['2'])}}</td>
        @else
            <td>-</td>
        @endif
        <td>
            <a class="btn btn-default btn-sm" href="{{url("/cabinet/payment-v1/create/?ak={$accountKey}&rt={$rowType}&pk={$row['account_entity_id']}")}}" title="Payment">Payment</a>
            @if (Group::isOwner())
                <a class="btn btn-default btn-sm" href="{{url("/cabinet/payment-adjustment/{$row['account_entity_id']}")}}" title="Adjustment">Adjustment</a>
            @endif
            <a class="btn btn-default btn-sm" href="{{url("/cabinet/schedule-payment/create?aei={$row['account_entity_id']}")}}" title="Schedule">Schedule</a>
            <a class="btn btn-default btn-sm" href="{{url("/cabinet/receipts-listing?id={$row['account_entity_id']}")}}" title="Receipt">Receipt</a>

        </td>
    </tr>
    @endforeach
@endif

                        </tbody>
                    </table>
                    @include('commons.modal')
                </div>
            </div>
        </div>

@endsection



@section('scripts')
<script type="text/javascript">

    $('#exam_account_type_4_receivable_id').change(function() {
        if (this.value == 'none') {
            window.location.href = "/cabinet/payment-v1";
        } else {
            var rowType = $(this).find(':selected').attr('data-rowtype');
            rowType = encodeURIComponent(rowType);
            window.location.href = "/cabinet/payment-v1?ak=" + this.value + "&rt=" + rowType;
        }
    });

</script>
@endsection
