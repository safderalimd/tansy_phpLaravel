@extends('layout.cabinet')

@section('title', 'Exam Setup')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Exam Setup</h3>
        	<a href="{{url('/cabinet/exam-setup/create/')}}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <!-- filter the exams -->
            <form class="form-horizontal" id="select-exam-form" action="{{url_with_query("/cabinet/exam-setup/copy/")}}" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="exam_entity_id">Exam</label>
                            <div class="col-md-4">
                                <select id="exam_entity_id" class="form-control" name="exam_entity_id">
                                    <option value="none">Select an exam..</option>
                                    @foreach($setup->examDropdown() as $option)
                                        <option {{activeSelect($option['exam_entity_id'], 'eei')}} value="{{$option['exam_entity_id']}}">{{$option['exam']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-primary grid_btn" type="submit">COPY EXAM SETUP FROM PREVIOUS YEAR</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Class Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Sub Exam <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Max Marks <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Average Reduced Marks <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($setup->examSetupGrid() as $item)
                    <tr>
                        <td>{{$item['class_name']}}</td>
                        <td>{{$item['subject']}}</td>
                        <td>{{$item['sub_exam']}}</td>
                        <td>{{$item['max_marks']}}</td>
                        <td>{{$item['average_reduced_marks']}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/exam-setup/edit/{$item['exam_schedule_id']}")}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/exam-setup/delete/{$item['exam_schedule_id']}")}}"
                               title="Delete"
                               data-title="Delete Exam Setup"
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

@section('scripts')
<script type="text/javascript">
    // reload the page when selecting an exam
    $('#exam_entity_id').change(function() {
        if (this.value == 'none') {
            window.location.href = "/cabinet/exam-setup";
        } else {
            window.location.href = "/cabinet/exam-setup?eei=" + this.value;
        }
    });

    $('#select-exam-form').validate({
        rules: {
            exam_entity_id: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection
