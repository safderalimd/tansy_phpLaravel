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

    <div id="watermark"><div id="watermark-text">{{$export->schoolName}}</div></div>

    <div class="footer text-right">
        Page: <span class="pagenum"></span>
    </div>

    <div class="container">

        @include('reports.common.pdf-header', [
            'school' => $export->schoolName,
            'phone'  => $export->schoolWorkPhone,
        ])

        @include('reports.common.report-name', ['report' => $export->reportName])

{{--         print student full name,
        parent name,

        student class,
        student roll number --}}

{{--         <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><h4><strong>Exam Start Date:</strong> </h4></td>
                        <td class="text-right"><h4><strong>Exam End Date:</strong> </h4></td>
                    </tr>
                    <tr>
                        <td class="text-left"><h4><strong>Class Name:</strong> </h4></td>
                        <td class="text-right"><h4><strong>Max Marks:</strong> </h4></td>
                    </tr>
                </table>
            </div>
        </div> --}}

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
