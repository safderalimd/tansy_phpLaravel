@extends('layout.cabinet')

@section('title', 'Exam Schedule')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Exam Schedule</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

                    <div class="row">
                        <div class="col-md-4">
                            @include('commons.select', [
                                'label'   => 'Exam' ,
                                'name'    => 'exam_entity_id',
                                'options' => $schedule->exam(),
                                'keyId'   => 'exam_entity_id',
                                'keyName' => 'exam',
                            ])
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary grid_btn" type="button">Map Subjects</button>
                        </div>
                    </div>

                    <hr/>

                   <table class="table table-striped table-bordered table-hover" data-datatable>
                    <thead>
                        <tr>
                            <th><input type="checkbox" name=""></th>
                            <th>Class <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Max Marks <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Exam Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Exam Time <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

            @foreach($schedule->scheduleExamGrid() as $item)
            <tr>
                <td><input type="checkbox" name=""></td>
                <td>{{$item['class_name']}}</td>
                <td>{{$item['subject']}}</td>
                <td>{{$item['max_marks']}}</td>
                <td>{{$item['exam_date']}}</td>
                <td>{{$item['exam_time']}}</td>
                <td>
                    <a class="btn btn-default formConfirm" href="{{url("/cabinet/exam-schedule/delete/{$item['exam_entity_id']}")}}"
                       title="Delete"
                       data-title="Delete Exam Schedule"
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
