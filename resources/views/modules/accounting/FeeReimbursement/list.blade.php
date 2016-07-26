@extends('layout.cabinet')

@section('title', 'Fee Reimbursement')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Fee Reimbursement</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="payment-type-id">Product</label>
                            <div class="col-md-8">
                                <select id="payment-type-id" class="form-control" name="payment-type-id">
                                    <option data-rowtype="none" value="none">Select a product..</option>
                                    @foreach($reimbursement->products() as $option)
                                        <option {{activeSelect($option['product_entity_id'], 'pi')}} value="{{ $option['product_entity_id'] }}">{{ $option['product'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="account-type-id">Account Type</label>
                            <div class="col-md-8">
                                <select id="account-type-id" class="form-control" name="account-type-id">
                                    <option data-rowtype="none" value="none">Select an account..</option>
                                    @foreach($reimbursement->accountTypeFilter() as $option)
                                        <option {{activeSelectByTwo($option['entity_id'], $option['row_type'], 'ak', 'rt')}} data-rowtype="{{$option['row_type']}}"  value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form id="amounts-table" class="form-horizontal" method="POST">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Total <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Paid <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Balance <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th style="width:250px">Reimbursement Amount</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($reimbursement->rows() as $item)
                    <tr>
                        <td>{{$item['student_full_name']}}</td>
                        <td>&#x20b9; {{amount($item['total_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['total_paid_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['due_amount'])}}</td>
                        <td>
                            <input data-rule-number="true" data-rule-min="0" data-aei="{{$item['account_entity_id']}}" data-sei="{{$item['schedule_entity_id']}}" data-dateid="{{$item['date_id']}}" data-totalamount="{{$item['total_amount']}}" type="text" name="reinbursement-amount" class="reinbursement-amount form-control">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </form>

            <nav class="nav-footer navbar navbar-default">
                <div class="container-fluid">
                    <form class="navbar-form navbar-right" id="update-reinbursement-form" action="{{form_action_full()}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="hidden_amounts" id="hidden_amounts" value="">

                        <a class="btn btn-default" href="/cabinet/payment-v2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
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

    $('#account-type-id, #payment-type-id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var ak = $('#account-type-id option:selected').val();
        var rt = $('#account-type-id option:selected').attr('data-rowtype');
        var pi = $('#payment-type-id option:selected').val();

        var items = [];
        if (ak != "none") {
            items.push('ak='+ak);
            items.push('rt='+rt);
        }
        if (pi != "none") {
            items.push('pi='+pi);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    $('#update-reinbursement-form').submit(function() {
        if (! $('#amounts-table').valid()) {
            return false;
        }

        var accountIds = $('.reinbursement-amount').map(function() {
            var aei = $(this).attr('data-aei');
            var sei = $(this).attr('data-sei');
            var dateid = $(this).attr('data-dateid');
            var totalamount = $(this).attr('data-totalamount');
            var reinbursement = parseFloat(this.value);
            if (isNaN(reinbursement)) {
                reinbursement = 0;
            }
            return aei + '-' + sei + '-' + dateid + '-' + totalamount + '-' + reinbursement;
        }).get();

        $('#hidden_amounts').val(accountIds.join(','));

        return true;
    });

    $('#amounts-table').validate();
</script>
@endsection
