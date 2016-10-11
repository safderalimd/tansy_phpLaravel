<!DOCTYPE html>
<html>
    <head>
        <title>Mark Sheet Detail</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">

        </style>
    </head>
    <body>

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

    <div class="container">

        <strong>

            @include('reports.common.pdf-header', [
                'school' => $grid->organizationName(),
                'line2'  => $grid->organizationLine2(),
                'line3'  => $grid->organizationLine3(),
            ])

            @include('reports.common.report-name', ['report' => $markSheet->reportName])

        </strong>

        <div class="row">
            <div class="col-md-12"><h4>Exam Name: {{$examName}}</h4></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4 class="">Class: {{$className}}</h4></td>
                        <td class="text-right"><h4 class="">Subject: {{$subjectName}}</h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
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
                    @foreach($allItems as $item)
                        <tr>
                            <td>{{$item['student_roll_number']}}</td>
                            <td>{{$item['student_full_name']}}</td>
                            @foreach ($columns as $column)
                                @if (isset($column['sub_exam_name']))
                                    <td>&nbsp;</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

    </div>
    </body>
</html>
