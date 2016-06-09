@extends('layout.cabinet')

@section('title', 'Subject')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Subject</h3>
        	<a href="{{url('/cabinet/subject/create/')}}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Subject Type <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Reporting Order <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subject->subjects() as $item)
                    <tr>
                        <td>{{$item['subject']}}</td>
                        <td>{{$item['subject_type']}}</td>
                        <td>{{$item['reporting_order']}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/subject/edit/{$item['subject_entity_id']}")}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/subject/delete/{$item['subject_entity_id']}")}}"
                               title="Delete"
                               data-title="Delete Subject"
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
