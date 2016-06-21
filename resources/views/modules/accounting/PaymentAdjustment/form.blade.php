@extends('layout.cabinet')

@section('title', 'Payment Adjustment')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Payment Adjustment{!! form_label() !!}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                     @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="payment-adjustment-form" class="form-horizontal" action="{{ url("/cabinet/payment-adjustment/update") }}" method="POST">
                        {{ csrf_field() }}


<!-- To know if we should process the form -->
<input type="hidden" name="process_form" value="true"/>

<input type="hidden" name="subject_entity_id" value="{{$adjustment->subject_entity_id}}"/>
<input type="hidden" name="schedule_entity_id" value="{{$adjustment->schedule_entity_id}}"/>
<input type="hidden" name="account_entity_id" value="{{$adjustment->account_entity_id}}"/>
<input type="hidden" name="date_id" value="{{$adjustment->date_id}}"/>
<input type="hidden" name="schedule_detail_id" value="{{$adjustment->schedule_detail_id}}"/>
<input type="hidden" name="product_entity_id" value="{{$adjustment->product_entity_id}}"/>
<input type="hidden" name="product_name" value="{{$adjustment->product_name}}"/>
<input type="hidden" name="account_name" value="{{$adjustment->account_name}}"/>
<input type="hidden" name="schedule_name" value="{{$adjustment->schedule_name}}"/>
<input type="hidden" name="current_schedule_name" value="{{$adjustment->current_schedule_name}}"/>
<input type="hidden" name="due_start_date" value="{{$adjustment->due_start_date}}"/>
<input type="hidden" name="due_end_date" value="{{$adjustment->due_end_date}}"/>
<input type="hidden" name="total_amount" value="{{$adjustment->total_amount}}"/>
<input type="hidden" name="total_credit_amount" value="{{$adjustment->total_credit_amount}}"/>
<input type="hidden" name="paid_amount" value="{{$adjustment->paid_amount}}"/>
<input type="hidden" name="old_adjustment_amount" value="{{$adjustment->adjustment_amount}}"/>
<input type="hidden" name="due_amount" value="{{$adjustment->due_amount}}"/>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Account</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$adjustment->account_name}}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Product</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$adjustment->product_name}}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Schedule Name</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$adjustment->schedule_name}}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Frequency Description</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$adjustment->current_schedule_name}}</div>
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'   => 'Adjustment Type' ,
                            'name'    => 'payment_type_id',
                            'options' => $adjustment->adjustmentType(),
                            'keyId'   => 'payment_type_id',
                            'keyName' => 'payment_type',
                            'none'    => 'Select an adjustment type..',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Scheduled Amount</label>
                            <div class="col-md-2">
                                <div class="well well-sm">{{$adjustment->total_amount}}</div>
                            </div>

                            <label class="col-md-4 control-label">Till Date Credit Amount</label>
                            <div class="col-md-2">
                                <div class="well well-sm">{{$adjustment->total_credit_amount}}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Due Before Adjustment</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$adjustment->paid_amount}}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="adjustment-amount">Adjustment Amount</label>
                            <div class="col-md-8">
                                <input id="adjustment-amount" class="form-control" type="text" name="adjustment_amount" value="{{ $adjustment->adjustment_amount }}" placeholder="Adjustment Amount">
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/payment-adjustment/{$adjustment->account_entity_id}")}}" class="btn btn-default cancle_btn">Cancel</a>
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

    $('#payment-adjustment-form').validate({
        rules: {
            payment_type_id: {
                requiredSelect: true
            },
            adjustment_amount: {
                required: true,
                number: true,
                min: 0
            }
        }
    });

</script>
@endsection
