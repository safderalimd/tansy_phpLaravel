@extends('layout.cabinet')

@section('title', 'Account Employee')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Account Employee</h3>
            <a href="{{url('/cabinet/account-employee/create/')}}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Account Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Department Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>City Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Mobile Number <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($account->employeesGrid() as $item)
                    <tr>
                        <td>{{$item['account_name']}}</td>
                        <td>{{$item['department_name']}}</td>
                        <td>{{$item['city_name']}}</td>
                        <td>{{phone_number($item['mobile_phone'])}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/account-employee/edit/{$item['account_entity_id']}")}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/account-employee/delete/{$item['account_entity_id']}")}}"
                               title="Delete"
                               data-title="Delete Account Employee"
                               data-message="Are you sure to delete the selected record?"
                            >
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
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
