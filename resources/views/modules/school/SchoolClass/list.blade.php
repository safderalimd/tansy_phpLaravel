@extends('layout.cabinet')

@section('title', 'School Classes')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
            	<div class="panel-heading">
                	<i class="glyphicon glyphicon-th-list"></i>
                	<h3>School Class</h3>
                	<a href="{!!url('/cabinet/class/create/')!!}" class="btn pull-right btn-default">Add new record</a>
                </div>
                <div class="panel-body">
                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Group <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Category <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                    <tr>
                        <td>{{$row['class_name']}}</td>
                        <td>{{$row['class_group']}}</td>
                        <td>{{$row['class_category']}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/class/edit/{$row['class_entity_id']}")}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/class/delete/{$row['class_entity_id']}")}}"
                               title="Delete"
                               data-title="Delete School Class"
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
