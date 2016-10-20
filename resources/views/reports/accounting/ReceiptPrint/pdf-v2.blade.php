<!DOCTYPE html>
<html>
    <head>
        <title>Receipt</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            @font-face {
                font-family: review;
                src: url({{url("/fonts/Review.ttf")}});
            }
            .text-bold {
                font-weight: bold;
            }
            .container {
                font-size: 12px;
                font-weight: normal;
                font-family: 'Helvetica';
                padding: 0px 0px 5px 0px;
                border: 1px solid rgb(221,221,221);
            }
            .header-row {
                margin: 0px;
                background-color: rgb(245,245,245);
                border-bottom: 1px solid #ccc;
                text-align: center;
            }
            .school-name {
                font-family: review;
                font-size: 50px;
                font-weight: bold;
            }
            .second-line {
                text-align: center;
                font-weight: bold;
                font-size: 16px;
            }
            .third-line {
                text-align: center;
                font-weight: bold;
                font-size: 16px;
            }
            .phone-line {
                text-align: center;
                font-weight: bold;
                font-size: 16px;
            }
            .report-name {
                font-weight: bold;
                font-size: 40px;
                margin: 0px;
            }
            .receipt-number,
            .receipt-date {
                padding-top: 20px;
            }
            .row {
                padding: 10px 15px;
            }
            .receipt-print-time {
                color: rgb(51,51,51);
                font-size: 10px;
            }
        </style>
    </head>
    <body>

    <div class="container">

        <div class="row header-row">
            <div class="col-md-12">
                <div class="row school-name">
                    <div class="col-md-12">{{$export->schoolName}}</div>
                </div>
                <div class="row second-line">
                   <div class="col-md-12">{{$export->headerSecondLine}}</div>
                </div>
                <div class="row third-line">
                    <div class="col-md-12">{{$export->headerThirdLine}}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 report-name text-left">
                {{$export->reportName}}
            </div>
            <div class="col-md-4 text-center receipt-number">
                No: {{$export->receiptNumber}}
            </div>
            <div class="col-md-4 text-right receipt-date text-bold">
                Date: {{$export->receiptDate}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 text-right text-bold">
                Received From:
            </div>
            <div class="col-md-9 text-left">
                {{$export->receivedFrom}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 text-right text-bold">
                Amount:
            </div>
            <div class="col-md-9 text-left">
                {{$export->receiptAmount}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 text-right text-bold">
                For Payment Of:
            </div>
            <div class="col-md-9 text-left">
                <table class="table">
                    @foreach ($export->details as $row)
                        <?php
                            $productName = isset($row['product_name']) ? $row['product_name'] : '-';
                            $productAmount = isset($row['product_credit_amount']) ? amount($row['product_credit_amount']) : '-';
                        ?>
                        <tr>
                            <td class="text-left">{{$productName}}</td>
                            <td class="text-right">&#x20b9; {{$productAmount}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 text-right text-bold">
                Received By:
            </div>
            <div class="col-md-4 text-left">
                {{$export->receivedBy}}
            </div>
            <div class="col-md-5 text-left">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center">This Payment</td>
                        <td class="text-right">&#x20b9; {{$export->thisPayment}}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Academic Due</td>
                        <td class="text-right">&#x20b9; {{$export->academicDue}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-left receipt-print-time">Receipt Print Time: {{current_datetime()}}</div>
        </div>

    </div>
    </body>
</html>
