<!DOCTYPE html>
<html>
    <head>
        <title>Fee Due Report</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
    </head>
    <body>

    <div class="footer text-right">
        Page: <span class="pagenum"></span>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="school-name text-center">{{$export->schoolName}}</h3>
                <h4 class="school-phone text-center">Phone No. {{phone_number_spaces($export->schoolWorkPhone)}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><h4 class="report-name text-center">{{$export->reportName}}</h4></div>
        </div>
        <div class="row">
            <div class="col-md-12"><h4>Filter: {{$export->filterCriteria}}</h4></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4 class="">Date: {{current_date()}}</h4></td>
                        <td class="text-right"><h4 class="">Time: {{current_time()}}</h4></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Student Name</th>
                        <th>Mobile Phone</th>
                        <th>Due Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($export->pdfData as $row)
                    <tr>
                        <td>{{$row['class_name']}}</td>
                        <td>{{$row['student_full_name']}}</td>
                        <td>{{phone_number($row['mobile_phone'])}}</td>
                        <td>&#x20b9; {{amount($row['due_amount'])}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </body>
</html>
