@extends('layout.cabinet')

@section('title', 'Payment Adjustment')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Payment Adjustment</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Account <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Product <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Schedule Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Frequency Desc. <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Amount Due <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Adjustment Amount <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

@foreach($rows as $row)
<tr>
    <td>{{$row['account_name']}}</td>
    <td>{{$row['product_name']}}</td>
    <td>{{$row['schedule_name']}}</td>
    <td>{{$row['current_schedule_name']}}</td>
    <td>{{$row['due_amount']}}</td>
    <td>{{$row['adjustment_amount']}}</td>
    <td>
        @if ($row['schedule_detail_id'] > 0)
            <div>
                <div>
                    <form action="{{url("/cabinet/payment-adjustment/edit")}}" method="POST">
                        {{ csrf_field() }}

                        <input type="hidden" name="subject_entity_id" value="{{$row['subject_entity_id']}}"/>
                        <input type="hidden" name="schedule_entity_id" value="{{$row['schedule_entity_id']}}"/>
                        <input type="hidden" name="account_entity_id" value="{{$row['account_entity_id']}}"/>
                        <input type="hidden" name="date_id" value="{{$row['date_id']}}"/>
                        <input type="hidden" name="schedule_detail_id" value="{{$row['schedule_detail_id']}}"/>
                        <input type="hidden" name="product_entity_id" value="{{$row['product_entity_id']}}"/>
                        <input type="hidden" name="product_name" value="{{$row['product_name']}}"/>
                        <input type="hidden" name="account_name" value="{{$row['account_name']}}"/>
                        <input type="hidden" name="schedule_name" value="{{$row['schedule_name']}}"/>
                        <input type="hidden" name="current_schedule_name" value="{{$row['current_schedule_name']}}"/>
                        <input type="hidden" name="due_start_date" value="{{$row['due_start_date']}}"/>
                        <input type="hidden" name="due_end_date" value="{{$row['due_end_date']}}"/>
                        <input type="hidden" name="total_amount" value="{{$row['total_amount']}}"/>
                        <input type="hidden" name="total_credit_amount" value="{{$row['total_credit_amount']}}"/>
                        <input type="hidden" name="paid_amount" value="{{$row['paid_amount']}}"/>
                        <input type="hidden" name="adjustment_amount" value="{{$row['adjustment_amount']}}"/>
                        <input type="hidden" name="due_amount" value="{{$row['due_amount']}}"/>

                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</button>
                    </form>
                </div>
                <div style="margin-top:5px;">
                    <form action="/cabinet/payment-adjustment/delete" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="schedule_detail_id" value="{{$row['schedule_detail_id']}}">
                        <input type="hidden" name="schedule_entity_id" value="{{$row['schedule_entity_id']}}">
                        <input type="hidden" name="date_id" value="{{$row['date_id']}}">
                        <input type="hidden" name="credited_to_entity_id" value="{{$row['account_entity_id']}}">
                        <input type="hidden" name="total_scheduled_amount" value="{{$row['total_amount']}}">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>
                    </form>
                </div>
            </div>
        @else
            <form action="{{url("/cabinet/payment-adjustment/add")}}" method="POST">
                {{ csrf_field() }}

                <input type="hidden" name="subject_entity_id" value="{{$row['subject_entity_id']}}"/>
                <input type="hidden" name="schedule_entity_id" value="{{$row['schedule_entity_id']}}"/>
                <input type="hidden" name="account_entity_id" value="{{$row['account_entity_id']}}"/>
                <input type="hidden" name="date_id" value="{{$row['date_id']}}"/>
                <input type="hidden" name="schedule_detail_id" value="{{$row['schedule_detail_id']}}"/>
                <input type="hidden" name="product_entity_id" value="{{$row['product_entity_id']}}"/>
                <input type="hidden" name="product_name" value="{{$row['product_name']}}"/>
                <input type="hidden" name="account_name" value="{{$row['account_name']}}"/>
                <input type="hidden" name="schedule_name" value="{{$row['schedule_name']}}"/>
                <input type="hidden" name="current_schedule_name" value="{{$row['current_schedule_name']}}"/>
                <input type="hidden" name="due_start_date" value="{{$row['due_start_date']}}"/>
                <input type="hidden" name="due_end_date" value="{{$row['due_end_date']}}"/>
                <input type="hidden" name="total_amount" value="{{$row['total_amount']}}"/>
                <input type="hidden" name="total_credit_amount" value="{{$row['total_credit_amount']}}"/>
                <input type="hidden" name="paid_amount" value="{{$row['paid_amount']}}"/>
                <input type="hidden" name="adjustment_amount" value="{{$row['adjustment_amount']}}"/>
                <input type="hidden" name="due_amount" value="{{$row['due_amount']}}"/>

                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
            </form>
        @endif

    </td>
</tr>
@endforeach

                        </tbody>
                    </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
