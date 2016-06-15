<!DOCTYPE html>
<html>
    <head>
        <title>Student Detail</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            td {
                vertical-align: top;
            }
            .table>tbody>tr>td,
            .table>tbody>tr>th,
            .table>tfoot>tr>td,
            .table>tfoot>tr>th,
            .table>thead>tr>td,
            .table>thead>tr>th {
                border-top: 0px;
            }

            .table>tbody>tr>td.left-td {
                padding: 0px 10px 0px 0px;
            }
            .table>tbody>tr>td.right-td {
                padding: 0px 0px 0px 10px;
            }

            body {
                font-family: courier;
                font-size: 14px;
            }

            .wrapper {
                padding-left: 70px;
                padding-bottom: 7px;
                text-align: left;
            }
            td {
                width: 300px;
            }
        </style>
    </head>
    <body>

    <?php
        $student = $export->pdfData;
    ?>

    <div id="watermark"><div id="watermark-text">{{$export->schoolName}}</div></div>

    <div class="footer text-right">
        Page: <span class="pagenum"></span>
    </div>

    <div class="container">

        <strong>

            @include('reports.common.pdf-header', [
                'school' => $export->schoolName,
                'phone'  => $export->schoolWorkPhone,
            ])

            @include('reports.common.report-name', ['report' => $export->reportName])

        </strong>

        <div class="row"><div class="cold-md-12"><h4>Student Details</h4></div></div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>First Name:</strong><br/> {{$student['first_name']}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Last Name:</strong><br/> {{$student['last_name']}}</div></td>
                    </tr>
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Date of Birth:</strong><br/> {{style_date($student['date_of_birth'])}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Gender:</strong><br/> {{$student['gender']}}</div></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row"><div class="cold-md-12"><h4>Contact Details</h4></div></div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Mobile Phone:</strong><br/>  {{phone_number($student['mobile_phone'])}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Home Phone:</strong><br/>  {{phone_number($student['home_phone'])}}</div></td>
                    </tr>
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Email:</strong><br/> {{$student['email']}}</div></td>
                        <td class="text-right"><div class="wrapper">&nbsp;</div></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row"><div class="cold-md-12"><h4>Home Address</h4></div></div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Address 1:</strong><br/> {{$student['address1']}}</div></td>
                    </tr>
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Address 2:</strong><br/> {{$student['address2']}}</div></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row"><div class="cold-md-12"><h4>Student Info</h4></div></div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Admission Number:</strong><br/> {{$student['admission_number']}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Admission Date:</strong><br/> {{style_date($student['admission_date'])}}</div></td>
                    </tr>
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Admitted To:</strong><br/> {{$student['admitted_to_class_group']}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Current Class:</strong><br/> {{$student['class_name']}}</div></td>
                    </tr>
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Roll Number:</strong><br/> {{$student['student_roll_number']}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Identification:</strong><br/> {{$student['identification1']}} {{$student['identification2']}}</div></td>
                    </tr>
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Caste Name:</strong><br/> {{$student['caste_name']}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Religion Name:</strong><br/> {{$student['religion_name']}}</div></td>
                    </tr>
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Communication Language:</strong><br/> {{$student['mother_tounge']}}</div></td>
                        <td class="text-right"><div class="wrapper">&nbsp;</div></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row"><div class="cold-md-12"><h4>Contact Details</h4></div></div>
        <div class="row">
            <div class="col-md-12">
                <table class="header-table">
                    <tr>
                        <td class="text-left"><div class="wrapper"><strong>Parent Name:</strong><br/> {{$student['parent_full_name']}}</div></td>
                        <td class="text-right"><div class="wrapper"><strong>Designation:</strong><br/> {{$student['parent_designation_name']}}</div></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    </body>
</html>
