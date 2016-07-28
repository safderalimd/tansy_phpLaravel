@extends('layout.cabinet')

@section('title', 'Daily Expense')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Daily Expense{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="daily-expense-form" class="form-horizontal" action="{{ form_action_full() }}" method="POST">
                        {{ csrf_field() }}

                        <input type="hidden" name="grid_filter_value" value="{{$queryString}}">

                        @include('commons.select', [
                            'label'    => 'Expense Type' ,
                            'name'     => 'expense_type_id',
                            'options'  => $expense->expenseTypes(),
                            'keyId'    => 'expense_type_id',
                            'keyName'  => 'expense_type',
                            'none'     => 'Select an expense type..',
                            'required' => true,
                        ])

                        @include('commons.select', [
                            'label'    => 'Supplier' ,
                            'name'     => 'supplier_organization_entity_id',
                            'options'  => $expense->organizationSupplier(),
                            'keyId'    => 'organization_entity_id',
                            'keyName'  => 'organization_name',
                            'none'     => 'Select a supplier..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="expense_date">Expense Date</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    @if ($expense->isNewRecord())
                                        <input id="expense_date" class="form-control" type="text" name="expense_date" value="{{ date('Y-m-d') }}" placeholder="Expense Date">
                                    @else
                                        <input id="expense_date" class="form-control" type="text" name="expense_date" value="{{ v('expense_date') }}" placeholder="Expense Date">
                                    @endif
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Payment Mode' ,
                            'name'     => 'payment_type_id',
                            'options'  => $expense->paymentTypes(),
                            'keyId'    => 'payment_type_id',
                            'keyName'  => 'payment_type',
                            'none'     => 'Select a payment type..',
                            'required' => true,
                        ])

                        <div class="form-group">
                             <label class="col-md-4 control-label required" for="amount">Amount</label>
                             <div class="col-md-8">
                                 <input id="amount" class="form-control" type="text" name="amount" value="{{ amount(v('amount')) }}" placeholder="Amount">
                             </div>
                        </div>

                        <div class="form-group">
                             <label class="col-md-4 control-label" for="notes">Notes</label>
                             <div class="col-md-8">
                                <textarea rows="5" placeholder="Notes" id="notes" class="form-control" name="notes">{{ v('notes') }}</textarea>
                             </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-offset-4 col-md-8">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/daily-expense")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">

    $('#daily-expense-form').validate({
        rules: {
            expense_type_id: {
                requiredSelect: true
            },
            expense_date: {
                required: true,
                dateISO: true
            },
            payment_type_id: {
                requiredSelect: true
            },
            amount: {
                required: true,
                number: true,
                min: 0
            }
        }
    });

</script>
@endsection
