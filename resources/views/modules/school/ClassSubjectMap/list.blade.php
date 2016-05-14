@extends('layout.cabinet')

@section('title', 'School Classes')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>School Classes</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Mapped</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            @foreach($subjects as $subject)
            <tr>
                <td>{{$subject['class_name']}}</td>
                <td>{{$subject['subject']}}</td>
                <td>{{$subject['mapped']}}</td>
                <td>
                    @if (strtolower($subject['mapped']) == 'yes')
                        <a class="btn btn-warning formConfirm" href="{{url("/cabinet/class-subject-map/delete/{$subject['subject_entity_id']}")}}"
                           title="Delete"
                           data-title="Delete School Class"
                           data-message="Are you sure to delete the selected record?"
                        >
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                        </a>
                    @else
                        <a class="btn btn-success formConfirm" href="{{url("/cabinet/class-subject-map/map/{$subject['subject_entity_id']}")}}"
                           title="Map"
                           data-title="Map School Class"
                           data-message="Are you sure to map the selected record?"
                        >
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Map
                        </a>
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
