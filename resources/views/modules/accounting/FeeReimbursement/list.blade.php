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
                                        <option {{activeSelect($option['product_entity_id'], 'pi')}} value="{{ $option['product_entity_id'] }}">{{ $option['product_name'] }}</option>
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

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="account_types_entity_id">Account Types</label>
                            <div class="col-md-8">
                                <select id="account_types_entity_id" class="form-control" name="account_types_entity_id">
                                    <option value="none">Select an account..</option>
                                    @foreach($reimbursement->accountTypeFilter() as $option)
                                        <option data-rowType="{{$option['row_type']}}" {{activeSelectByTwo($option['entity_id'], $option['row_type'], 'aei', 'art')}} value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
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
                        <th class="text-center"><input type="checkbox" id="toggle-subjects" name="toggle-checkbox" value=""></th>
                        <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Total <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Paid <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Balance <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Due Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th style="width:130px">Paid Amount</th>
                        <th style="width:130px">Receipt Number</th>
                        <th style="width:130px">Receipt Date</th>
                    </tr>
                </thead>
                <tbody>

                <?php $i = 0; ?>
                @foreach($reimbursement->rows() as $item)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="payment-row-id" name="payment_id" value="">
                        </td>
                        <td>{{$item['student_full_name']}}</td>
                        <td>&#x20b9; {{amount($item['total_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['total_paid_amount'])}}</td>
                        <td>&#x20b9; {{amount($item['due_amount'])}}</td>
                        <td>{{style_date($item['due_start_date'])}}</td>
                        <td>
                            <input disabled="disabled" data-rule-required="true" data-rule-number="true" data-rule-min="0" data-aei="{{$item['account_entity_id']}}" data-sei="{{$item['schedule_entity_id']}}" data-dateid="{{$item['date_id']}}" data-totalamount="{{$item['total_amount']}}" data-balance="{{$item['due_amount']}}" type="text" name="{{$i++}}reinbursement-amount" class="reinbursement-amount form-control paidAmountValidation">
                        </td>
                        <td>
                            <input disabled="disabled" data-rule-number="true" data-rule-min="0" type="text" name="{{$i}}receipt-number" class="receipt-number form-control">
                        </td>
                        <td>
                            <div class="input-group date">
                                <input disabled="disabled" class="receipt-date form-control" type="text" name="{{$i}}exam_date" value="">
                                <span class="input-group-btn">
                                    <button disabled="disabled" class="date-btn btn btn-default" type="button"><span
                                                class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
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
                                    @foreach($reimbursement->paymentTypes() as $option)
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

    // paid amount can't be greter than balance
    $.validator.addMethod('paidAmountValidation', function(value, element) {
        var balance = $(element).attr('data-balance');
        balance = parseFloat(balance);
        if (balance < parseFloat(value)) {
            return false;
        }
        return true;
    }, "Paid Amount can't be larger than Balance.");

    $('#amounts-table table').DataTable({
        "aaSorting": [],
        "autoWidth": false
    });

    $('#amounts-table table').on('draw.dt', function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            onSelect: function(dateText) {
                $(this).change();
            }
        });
    });

    $('#fiscal_years, #product_type_id, #account_types_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var fi = $('#fiscal_years option:selected').val();
        var pi = $('#product_type_id option:selected').val();
        var aei = $('#account_types_entity_id option:selected').val();
        var art = $('#account_types_entity_id option:selected').attr('data-rowType');

        var items = [];
        if (fi != "none") {
            items.push('fi='+fi);
        }
        if (pi != "none") {
            items.push('pi='+pi);
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

    $('#update-reinbursement-form').submit(function() {
        if (! $('#amounts-table').valid()) {
            return false;
        }
        if (! $('#update-reinbursement-form').valid()) {
            return false;
        }

        var accountIds = $('.payment-row-id:checked').map(function() {
            var reinbursementInput = $(this).closest('tr').find('.reinbursement-amount');

            var aei = $(reinbursementInput).attr('data-aei');
            var sei = $(reinbursementInput).attr('data-sei');
            var dateid = $(reinbursementInput).attr('data-dateid');
            var totalamount = $(reinbursementInput).attr('data-totalamount');
            var reinbursement = $(reinbursementInput).val();
            if (reinbursement !== 0 && !reinbursement) {
                reinbursement = 'null';
            }

            var receiptNumber = $(this).closest('tr').find('.receipt-number').val();
            if (receiptNumber !== 0 && !receiptNumber) {
                receiptNumber = 'null';
            }

            var receiptDate = $(this).closest('tr').find('.receipt-date').val();
            if (!receiptDate) {
                receiptDate = 'null';
            }

            return aei + '|' + sei + '|' + dateid + '|' + totalamount + '|' + reinbursement + '|' + receiptNumber + '|' + receiptDate;
        }).get();

        $('#hidden_amounts').val(accountIds.join(','));

        return true;
    });

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            var table = $('.table').DataTable();
            var rows = table.rows({ page: 'current' }).nodes();
            rows.each(function() {
                $('.payment-row-id', this).prop('checked', true)
                $('.payment-row-id', this).closest('tr').find('input[type="text"]').prop('disabled', false);
                $('.payment-row-id', this).closest('tr').find('.date-btn').prop('disabled', false);
            });
        } else {
            $('.payment-row-id').prop('checked', false);
            $('.payment-row-id').closest('tr').find('input[type="text"]').prop('disabled', true);
            $('.payment-row-id').closest('tr').find('.date-btn').prop('disabled', true);
        }
    });

    // reset all checkboxes after you change the page
    $('#amounts-table').on('page.dt', function () {
        $('.payment-row-id').prop('checked', false);
        $('.payment-row-id').closest('tr').find('input[type="text"]').prop('disabled', true);
        $('.payment-row-id').closest('tr').find('.date-btn').prop('disabled', true);
        $('#toggle-subjects').prop('checked', false);
    });

    $(document).on('change', '.payment-row-id', function() {
        if ($(this).is(':checked')) {
            $(this).closest('tr').find('input[type="text"]').prop('disabled', false);
            $(this).closest('tr').find('.date-btn').prop('disabled', false);
        } else {
            $(this).closest('tr').find('input[type="text"]').prop('disabled', true);
            $(this).closest('tr').find('.date-btn').prop('disabled', true);
        }
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
