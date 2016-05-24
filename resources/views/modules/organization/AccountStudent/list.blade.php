@extends('layout.cabinet')

@section('title', 'Student Accounts')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Student Accounts</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th>Student Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Mobile Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

            @foreach($account->students() as $student)
            <tr>
                <td>
                    <a class="" href="{{url("/cabinet/student-dashboard?csi={$student['class_student_id']}&sei={$student['student_entity_id']}")}}" title="Student Dashboard">{{$student['student_full_name']}}</a>
                </td>
                <td>{{$student['class_name']}}</td>
                <td>{{$student['mobile_phone']}}</td>
                <td>
                    <a class="btn btn-default" href="{{url("/cabinet/student-account/edit/{$student['student_entity_id']}")}}" title="Edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/student-account/delete/{$student['student_entity_id']}")}}"
                       title="Delete"
                       data-title="Delete Student Account"
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
