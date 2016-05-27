<!DOCTYPE html>
<html>
    <head>
        <title>Receipt</title>
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
                            <th class="text-center"><h4 class=""><strong>Student Name</strong> <br/> {{$export->header['paid_by_name']}}</h4></th>
                            <th class="text-center"><h4 class=""><strong>Mobile No.</strong> <br/> {{phone_number($export->header['mobile_phone'])}}</h4></th>
                            <th class="text-center"><h4 class=""><strong>Receipt No.</strong> <br/> {{$export->header['receipt_number']}}</h4></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Description</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($export->details as $row)
                    <tr>
                        <td class="text-left">{{$row['description']}}</td>
                        <td class="text-right">{{amount($row['credit_amount'])}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="text-right well  well-sm">Total Paid: {{amount($export->header['receipt_amount'])}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="text-right well  well-sm">New Balance: {{amount($export->header['new_balance'])}}</div>
            </div>
        </div>

    </div>
    </body>
</html>
