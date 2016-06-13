<!DOCTYPE html>
<html>
<head>
    <title>Daily Collection Report</title>
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

        <div class="row">
            <div class="col-md-12"><h4>Start Date: {{style_date($export->start)}} </h4></div>
        </div>
        <div class="row">
            <div class="col-md-12"><h4>End Date: {{style_date($export->end)}} </h4></div>
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
                        <th class="text-left">Date</th>
                        <th class="text-left">System Collection</th>
                        <th class="text-left">Cash Counter Collection</th>
                        <th class="text-left">Closed By</th>
                        <th class="text-left">Closed Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($export->pdfData as $row)
                    <tr>
                        <td class="text-left">{{style_date($row['calendar_date'])}}</td>
                        <td class="text-left">{{amount($row['receipt_collection_amount'])}}</td>
                        <td class="text-left">{{amount($row['cash_counter_amount'])}}</td>
                        <td class="text-left">{{$row['closed_by']}}</td>
                        <td class="text-left">{{$row['closed_datetime']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

    </div>

</body>
</html>
