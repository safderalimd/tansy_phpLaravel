<!DOCTYPE html>
<html>
    <head>
        <title>Account Statement</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">

        </style>
    </head>
    <body>

    <div class="container">

        @include('reports.common.pdf-header', [
            'school' => $export->organizationName(),
            'phone'  => $export->organizationLine2(),
        ])

        @include('reports.common.report-name', ['report' => $export->reportName])

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4><strong>Student Name:</strong> {{$export->studentData['student_full_name']}} </h4></td>
                        <td class="text-right"><h4><strong>Class:</strong> {{$export->studentData['class_name']}} </h4></td>
                    </tr>
                    <tr>
                        <td class="text-left"><h4><strong>Parent Name:</strong> {{$export->studentData['parent_full_name']}} </h4></td>
                        <td class="text-right"><h4><strong>Roll Number:</strong> {{$export->studentData['student_roll_number']}} </h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4 class="">Print Date: {{current_date()}}</h4></td>
                        <td class="text-right"><h4 class="">Print Time: {{current_time()}}</h4></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Receipt Number</th>
                        <th>Receipt Date</th>
                        <th>Receipt Amount</th>
                        <th>New Balance</th>
                        <th>Financial Year Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($export->pdfData as $row)
                    <tr>
                        <td>{{$row['receipt_number']}}</td>
                        <td>{{style_date($row['receipt_date'])}}</td>
                        <td>{{amount($row['receipt_amount'])}}</td>
                        <td>{{amount($row['new_balance'])}}</td>
                        <td>{{amount($row['financial_year_balance'])}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

    </div>
    </body>
</html>
