<!DOCTYPE html>
<html>
    <head>
        <title>Hall Ticket</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            body {
                font-size: 12px;
            }
            .ticket-box {
                border: 1px solid #ccc;
                padding: 0px 15px 0px 15px;
                margin-bottom: 85px;
            }
            .hall-ticket-name {
                text-decoration: underline;
            }
            .principal-signature {
                margin-top: -10px;
                padding-bottom: 25px
            }
            .student-picture img {
                max-width: 100px;
                max-height: 100px;
            }
        </style>
    </head>
    <body>

    <div class="container">

    @foreach($export->tickets as $ticket)
        <div class="ticket-box">
        <?php

            $examName = isset($ticket[0]['exam']) ? $ticket[0]['exam'] : '';
            $className = isset($ticket[0]['class_name']) ? $ticket[0]['class_name'] : '';
            $studentName = isset($ticket[0]['student_full_name']) ? $ticket[0]['student_full_name'] : '';
            $rollNumber = isset($ticket[0]['student_roll_number']) ? $ticket[0]['student_roll_number'] : '';
            $studentId = isset($ticket[0]['student_entity_id']) ? $ticket[0]['student_entity_id'] : '-';

            $datesRow = [];
            $weekdaysRow = [];
            $subjectsRow = [];

            foreach($ticket as $subjects) {
                $datesRow[] = date("M jS", strtotime($subjects['exam_date']));
                $weekdaysRow[] = date("l", strtotime($subjects['exam_date']));
                $subjectsRow[] = $subjects['subject_short_code'];
            }

        ?>

        <div class="row">
            <div class="col-md-12">
                <h3 class="school-name text-center">{{$export->schoolName}}</h3>
                <h4 class="school-phone text-center">{{$export->schoolCity}} (Phone: {{phone_number_spaces($export->schoolWorkPhone)}})</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left">
                            <h3 class="hall-ticket-name report-name text-left">Hall Ticket - {{$export->fiscalYear}}</h3>
                            <h4 class="">Exam: {{$examName}}</h4>
                            <h4 class="">Student Name: {{$studentName}}</h4>
                            <h4 class="">Class: {{$className}}, Roll No: {{$rollNumber}}</h4>
                        </td>
                        <td>
                            <div class="student-picture">
                                <img src="{{student_picture($studentId)}}" class="" alt="Image">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @for ($i=0;$i<count($datesRow);$i++)
                            <th class="text-center">
                                {{$datesRow[$i]}} <br/>
                                {{$weekdaysRow[$i]}}
                            </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($subjectsRow as $subjects)
                            <td>{{$subjects}}</td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($subjectsRow as $subjects)
                            <td class="text-center" style="height: 34px;"></td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <h4 class="principal-signature text-right">Principal Signature</h4>
            </div>
        </div>

        </div>
    @endforeach
    </div>
    </body>
</html>
