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

        @include('reports.common.pdf-header', [
            'school' => $export->schoolName,
            'phone'  => $export->schoolWorkPhone,
        ])

        @include('reports.common.report-name', ['report' => $export->reportName])

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
                <div class="well">
                    <table class="table header-table">
                        <tr>
                            <td>
                                <div class="">
                                    <h2>Student</h2>
                                    <h5><br/>Full Name: {{$student['student_full_name']}}
                                    <br/>First Name: {{$student['first_name']}}
                                    <br/>Middle Name: {{$student['middle_name']}}
                                    <br/>Last Name: {{$student['last_name']}}
                                    <br/>Gender: {{$student['gender']}}
                                    <br/>Date of Birth: {{style_date($student['date_of_birth'])}}
                                    <br/>Identification: {{$student['identification1']}} {{$student['identification2']}}
                                    <br/>Caste Name: {{$student['caste_name']}}
                                    <br/>Religion Name: {{$student['religion_name']}}
                                    <br/>Mother Tongue: {{$student['mother_tounge']}}
                                    </h5>
                                </div>
                            </td>
                            <td>
                                <div class="">
                                    <h2>Parent</h2>
                                    <h5><br/>Full Name: {{$student['parent_full_name']}}
                                    <br/>First Name: {{$student['parent_first_name']}}
                                    <br/>Middle Name: {{$student['parent_middle_name']}}
                                    <br/>Last Name: {{$student['parent_last_name']}}
                                    <br/>Gender: {{$student['parent_gender']}}
                                    <br/>Parent Relationship: {{$student['parent_relationship']}}
                                    <br/>Designation: {{$student['parent_designation_name']}}
                                    </h5>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table header-table">
                    <tr>
                        <td class="left-td">
                            <div class="well">
                                <h5>Class: {{$student['class_name']}}
                                <br/><br/>Roll Number: {{$student['student_roll_number']}}
                                <br/><br/>Admission Number: {{$student['admission_number']}}
                                <br/><br/>Admission Date:  {{style_date($student['admission_date'])}}
                                <br/><br/>Fiscal Year:  {{$student['fiscal_year']}}
                                </h5>
                            </div>
                        </td>
                        <td class="right-td">
                            <div class="well">
                                <h5>Address 1:   {{$student['address1']}}
                                <br/><br/>Address 2:  {{$student['address2']}}
                                <br/><br/>City:  {{$student['city_name']}}
                                <br/><br/>City Area:  {{$student['city_area']}}
                                <br/><br/>Postal:  {{$student['postal_code']}}
                                <br/><br/>Mobile Phone:  {{phone_number($student['mobile_phone'])}}
                                <br/><br/>Home Phone:  {{phone_number($student['home_phone'])}}
                                <br/><br/>Email:  {{$student['email']}}
                                </h5>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    </body>
</html>
