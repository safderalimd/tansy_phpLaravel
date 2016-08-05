@extends('layout.cabinet')

@section('title', 'Payment v2')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Payment v2</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="product_type_id">Product</label>
                            <div class="col-md-8">
                                <select id="product_type_id" class="form-control" name="product_type_id">
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
                            <label class="col-md-4 control-label" for="fiscal_years">Fiscal Year</label>
                            <div class="col-md-8">
                                <select id="fiscal_years" class="form-control" name="fiscal_year_entity_id">
                                    <option value="none">Select a fiscal year..</option>
                                    @foreach($reimbursement->fiscalYears() as $year)
                                        <option {{activeSelect($year['fiscal_year_entity_id'], 'fi')}} value="{{$year['fiscal_year_entity_id']}}">{{$year['fiscal_year']}}</option>
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
                        <th>Due Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
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
                        <td>{{style_date($item['due_start_date'])}}</td>
                        <td>
                            <input data-rule-number="true" data-rule-min="0" data-aei="{{$item['account_entity_id']}}" data-sei="{{$item['schedule_entity_id']}}" data-dateid="{{$item['date_id']}}" data-totalamount="{{$item['total_amount']}}" type="text" name="reinbursement-amount" class="reinbursement-amount form-control">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </form>

            <form class="form-horizontal" id="update-reinbursement-form" action="{{form_action_full()}}" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4 col-md-offset-8">
                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="payment_type_id">Payment Type</label>
                            <div class="col-md-8">
                                <select id="payment_type_id" class="form-control" name="payment_type_id">
                                    <option data-rowtype="none" value="none">Select a product..</option>
                                    @foreach($reimbursement->paymentType() as $option)
                                        <option value="{{ $option['payment_type_id'] }}">{{ $option['payment_type'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="nav-footer navbar navbar-default">

                    <input type="hidden" name="hidden_amounts" id="hidden_amounts" value="">

                    <button style="margin-top:8px;" type="submit" class="pull-right btn btn-primary">Save</button>
                    <a style="margin-top:8px; margin-right:10px;" class="pull-right btn btn-default" href="/cabinet/payment-v2">Cancel</a>
               </nav>
            </form>
            @include('commons.modal')

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $('#amounts-table table').DataTable({
        "aaSorting": [],
        "autoWidth": false
    });

    $('#fiscal_years, #product_type_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var fi = $('#fiscal_years option:selected').val();
        var pi = $('#product_type_id option:selected').val();

        var items = [];
        if (fi != "none") {
            items.push('fi='+fi);
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
        if (! $('#update-reinbursement-form').valid()) {
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

    $('#update-reinbursement-form').validate({
        rules: {
            payment_type_id: {
                requiredSelect: true
            }
        }
    });
    $('#amounts-table').validate();
</script>
@endsection
