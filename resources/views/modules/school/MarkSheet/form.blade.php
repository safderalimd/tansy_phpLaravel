@extends('layout.cabinet')

@section('title', 'Mark Sheet Detail')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Mark Sheet Detail</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <?php
                        $data = $markSheet->marksGrid();
                        $allItems = first_resultset($data);
                        $columns = second_resultset($data);

                        $examEntityId = $markSheet->exam_entity_id;
                        $classEntityId = $markSheet->class_entity_id;
                        $subjectEntityId = $markSheet->subject_entity_id;

                        $examName = isset($columns[0]['main_exam_name']) ? $columns[0]['main_exam_name'] : '-';
                        $className = isset($columns[0]['class_name']) ? $columns[0]['class_name'] : '-';
                        $subjectName = isset($columns[0]['subject_name']) ? $columns[0]['subject_name'] : '-';

                        $maxMarks = 0;
                        foreach ($columns as $column) {
                            if (isset($column['average_reduced_marks']) && is_numeric($column['average_reduced_marks'])) {
                                $maxMarks += $column['average_reduced_marks'];
                            }
                        }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="pull-left"><strong>{{$examName}}</strong></h3>
                        </div>
                    </div>
                    <hr style="margin:0px; padding:0px;" />
                    <div class="row">
                        <div class="col-md-6"><h4 class="pull-left">Class - {{$className}}</h4></div>
                        <div class="col-md-6"><h4 class="pull-right">Subject - {{$subjectName}}</h4></div>
                    </div>
                    <hr style="margin:0px; padding:0px;" />
                    <div class="row" style="">
                        <div class="col-md-12">
                            <h4 class="pull-right">Max Marks - {{$maxMarks}}</h4>
                        </div>
                    </div>

                    <hr style="margin-top:0px;" />

                    <form id="marks-table" class="form-horizontal" method="POST">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Student Name</th>
                                @foreach ($columns as $column)
                                    @if (isset($column['sub_exam_name']))
                                        <th>
                                            {{$column['sub_exam_name']}}
                                            @if (isset($column['max_marks']))
                                                <br/> <span class="small text-muted">Max. {{$column['max_marks']}}</span>
                                            @endif
                                        </th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($allItems as $item)
                                <tr>
                                    <td>{{$item['student_roll_number']}}</td>
                                    <td>{{$item['student_full_name']}}</td>
                                    <?php $j = 1; ?>
                                    @foreach ($columns as $column)
                                        @if (isset($column['sub_exam_name']))
                                            <td style="max-width:150px;width:150px;">
                                                <?php
                                                    $mark = isset($item[$column['sub_exam_name']]) ? $item[$column['sub_exam_name']] : '';
                                                ?>
                                                <input data-rule-number="true" data-rule-min="0" data-scheduleId="{{$column['exam_schedule_id']}}" data-studentId="{{$item['class_student_id']}}" class="input-mark-value form-control" type="text" name="marks_name_{{$i++}}{{$j++}}" value="{{$mark}}">
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </form>

                    <hr/>
                    <div class="row">
                        <div class="col-md-7 text-left col-md-offset-5">

                        <form class="form-horizontal" id="save-marks-form" action="{{url("/cabinet/mark-sheet/save?eid={$examEntityId}")}}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="exSchID_clsStudntID_marks" id="exSchID_clsStudntID_marks" value="">

                            <input type="hidden" name="exam_entity_id" id="id-exam_entity_id" value="{{$examEntityId}}">
                            <input type="hidden" name="class_entity_id" id="id-class_entity_id" value="{{$classEntityId}}">
                            <input type="hidden" name="subject_entity_id" id="id-subject_entity_id" value="{{$subjectEntityId}}">

                            <button class="btn btn-primary grid_btn" type="submit" id="save-marks-submit">Save</button>
                            <a href="{{ url("/cabinet/mark-sheet?eid=".queryStringValue('eid'))}}" class="btn btn-default cancle_btn">Cancel</a>
                        </form>

                        </div>
                    </div>
                    <br/>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript">

    // When submitting the form, prepend all selected checkboxes
    $('#save-marks-form').submit(function() {
        if (! $('#marks-table').valid()) {
            return false;
        }

        var marksIds = $('.input-mark-value').map(function() {
            var mark = this.value;
            if (mark !== 0 && !mark) {
                mark = 'null';
            }
            return $(this).attr('data-scheduleId') + '<$$>' + $(this).attr('data-studentId') + '<$$>' + mark;
        }).get();

        if (marksIds.length == 0) {
            alert("There are no marks.");
            return false;
        }

        $('#exSchID_clsStudntID_marks').val(marksIds.join('|'));

        return true;
    });

    $('#marks-table').validate();

</script>
@endsection
