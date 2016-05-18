@extends('layout.cabinet')

@section('title', 'Schedule Payment')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Schedule Payment{!! form_label() !!}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input {{ c('active') }} name="active" type="checkbox"> Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'   => 'Facility Type' ,
                            'name'    => 'facility_ids',
                            'options' => $payment->facilities(),
                            'keyId'   => 'facility_entity_id',
                            'keyName' => 'facility_name',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="product">Name</label>
                            <div class="col-md-8">
                                <input id="product" class="form-control" type="text" name="schedule_name" value="{{ v('schedule_name') }}" placeholder="Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'   => 'Product' ,
                            'name'    => 'product_entity_id',
                            'options' => $payment->products(),
                            'keyId'   => 'product_entity_id',
                            'keyName' => 'product',
                        ])

                        @include('commons.select', [
                            'label'   => 'Account Type' ,
                            'name'    => 'account_type_id',
                            'options' => $payment->accountType(),
                            'keyId'   => 'entity_type_id',
                            'keyName' => 'entity_type',
                        ])

                        @include('commons.select', [
                            'label'   => 'Subject Account' ,
                            'name'    => 'subject_entity_id',
                            'options' => $payment->entityName(),
                            'keyId'   => 'entity_id',
                            'keyName' => 'entity_name',
                        ])

                        @include('commons.select', [
                            'label'   => 'Frequency' ,
                            'name'    => 'frequency_id',
                            'options' => $payment->frequency(),
                            'keyId'   => 'frequency_id',
                            'keyName' => 'description',
                        ])


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="start_date">Start Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group date">
                                            <input id="start_date" class="form-control" type="text" name="start_date" value="{{ v('start_date') }}" placeholder="Start Date">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span
                                                            class="glyphicon glyphicon-calendar"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="end_date">End Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group date">
                                            <input id="end_date" class="form-control" type="text" name="end_date" value="{{ v('end_date') }}" placeholder="End Date">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span
                                                            class="glyphicon glyphicon-calendar"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="amount">Amount</label>
                                    <div class="col-md-8">
                                        <input id="amount" class="form-control" type="text" name="amount" value="{{ v('amount') }}" placeholder="Amount">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="due_date_days_value">Due Days</label>
                                    <div class="col-md-8">
                                        <input id="due_date_days_value" class="form-control" type="text" name="due_date_days_value" value="{{ v('due_date_days_value') }}" placeholder="Due Days">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/schedule-payment")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
