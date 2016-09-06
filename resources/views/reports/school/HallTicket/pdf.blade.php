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
        </style>
    </head>
    <body>

    <div id="watermark"><div id="watermark-text">{{$export->schoolName}}</div></div>

    <div class="container">

    @foreach($export->tickets as $ticket)

        <div class="row">
            {{-- <div class="col-md-4"> --}}
            {{-- logo-container --}}
                {{-- include('reports.common.pdf-logo-img') --}}
            {{-- </div> --}}
            <div class="col-md-12">
            {{-- school-container --}}
                <h3 class="school-name text-center">{{$export->schoolName}}</h3>
                <h4 class="school-phone text-center">{{$export->schoolCity}} (Phone: {{phone_number_spaces($export->schoolWorkPhone)}})</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12"><h4 class="report-name text-center">{{$export->reportName}}</h4></div>
        </div>

        <?php
            $examName = isset($ticket[0]['exam']) ? $ticket[0]['exam'] : '';
            $className = isset($ticket[0]['class_name']) ? $ticket[0]['class_name'] : '';
            $studentName = isset($ticket[0]['student_full_name']) ? $ticket[0]['student_full_name'] : '';
            $rollNumber = isset($ticket[0]['student_roll_number']) ? $ticket[0]['student_roll_number'] : '';
        ?>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4 class="">Exam: {{$examName}}</h4></td>
                        <td class="text-right"><h4 class="">Class: {{$className}}</h4></td>
                    </tr>
                    <tr>
                        <td class="text-left"><h4 class="">Student Name: {{$studentName}}</h4></td>
                        <td class="text-right"><h4 class="">Roll Number: {{$rollNumber}}</h4></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        @foreach($ticket as $subjects)
                            <th>{{style_date($subjects['exam_date'])}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($ticket as $subjects)
                            <td>{{$subjects['subject_name']}}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

    @endforeach
    </div>
    </body>
</html>
