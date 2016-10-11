@extends('layout.cabinet')

@section('title', 'Fiscal Years')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Fiscal Years</h3>
            <a href="{{url('/cabinet/fiscal-year/create/')}}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

        @include('commons.errors')

        <table class="table table-striped table-bordered table-hover" data-datatable>
            <thead>
                <tr>
                    <th>Fiscal Year <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Start Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>End Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Current Year <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($fiscalYear->allFiscalYears() as $row)
            <tr>
                <td>{{$row['fiscal_year']}}</td>
                <td>{{style_date($row['start_date'])}}</td>
                <td>{{style_date($row['end_date'])}}</td>
                <td>
                    @if ($row['current_fiscal_year'] == 1)
                        <strong>Yes</strong>
                    @else
                        No
                    @endif
                </td>
                <td>
                    <a class="btn btn-default" href="{{url("/cabinet/fiscal-year/edit/{$row['fiscal_year_entity_id']}")}}" title="Edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/fiscal-year/delete/{$row['fiscal_year_entity_id']}")}}"
                       title="Delete"
                       data-title="Delete Fiscal Year"
                       data-message="Are you sure to delete the selected record?"
                    >
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
            </tr>
            @endforeach
            </tbody>
        </table>

        @include('commons.modal')

        </div>
    </div>
</div>

@endsection
