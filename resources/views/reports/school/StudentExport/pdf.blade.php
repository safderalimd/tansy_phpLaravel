<!DOCTYPE html>
<html>
    <head>
        <title>Student Export</title>
        @include('reports.common.bootstrap')
        @include('reports.common.css')
        <style type="text/css">
            @if ($export->attributesCount() > 25)
                body {
                    font-size: 8px;
                }

                .table>tbody>tr>td,
                .table>tbody>tr>th,
                .table>tfoot>tr>td,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>thead>tr>th {
                    padding: 3px;
                }
            @elseif ($export->attributesCount() > 20)
                body {
                    font-size: 9px;
                }

                .table>tbody>tr>td,
                .table>tbody>tr>th,
                .table>tfoot>tr>td,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>thead>tr>th {
                    padding: 4px;
                }
            @endif
        </style>
    </head>
    <body>

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
            <div class="col-md-12"><h4>Filter: {{$export->filterCriteria()}}</h4></div>
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
                        @if (isset($export->first_name))
                            <th>First Name</th>
                        @endif
                        @if (isset($export->last_name))
                            <th>Last Name</th>
                        @endif
                        @if (isset($export->date_of_birth))
                            <th>Date Of Birth</th>
                        @endif
                        @if (isset($export->gender))
                            <th>Gender</th>
                        @endif
                        @if (isset($export->class_name))
                            <th>Class Name</th>
                        @endif
                        @if (isset($export->roll_number))
                            <th>Roll Number</th>
                        @endif
                        @if (isset($export->admission_number))
                            <th>Admission Number</th>
                        @endif
                        @if (isset($export->admission_date))
                            <th>Admission Date</th>
                        @endif
                        @if (isset($export->identification1))
                            <th>Identification1</th>
                        @endif
                        @if (isset($export->parent_full_name))
                            <th>Parent Full Name</th>
                        @endif
                        @if (isset($export->parent_designation))
                            <th>Parent Designation</th>
                        @endif
                        @if (isset($export->caste))
                            <th>Caste</th>
                        @endif
                        @if (isset($export->religion))
                            <th>Religion</th>
                        @endif
                        @if (isset($export->mother_toungue))
                            <th>Mother Toungue</th>
                        @endif
                        @if (isset($export->mobile))
                            <th>Mobile</th>
                        @endif
                        @if (isset($export->address1))
                            <th>Address1</th>
                        @endif
                        @if (isset($export->address2))
                            <th>Address2</th>
                        @endif
                        @if (isset($export->city))
                            <th>City</th>
                        @endif
                        @if (isset($export->postal_code))
                            <th>Postal Code</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($export->pdfData as $row)
                    <tr>
                        @if (isset($export->first_name))
                            <td>{{$row['first_name']}}</td>
                        @endif
                        @if (isset($export->last_name))
                            <td>{{$row['last_name']}}</td>
                        @endif
                        @if (isset($export->date_of_birth))
                            <td>{{style_date($row['date_of_birth'])}}</td>
                        @endif
                        @if (isset($export->gender))
                            <td>{{$row['gender']}}</td>
                        @endif
                        @if (isset($export->class_name))
                            <td>{{$row['class_name']}}</td>
                        @endif
                        @if (isset($export->roll_number))
                            <td>{{$row['student_roll_number']}}</td>
                        @endif
                        @if (isset($export->admission_number))
                            <td>{{$row['admission_number']}}</td>
                        @endif
                        @if (isset($export->admission_date))
                            <td>{{style_date($row['admission_date'])}}</td>
                        @endif
                        @if (isset($export->identification1))
                            <td>{{$row['identification1']}}</td>
                        @endif
                        @if (isset($export->parent_full_name))
                            <td>{{$row['parent_full_name']}}</td>
                        @endif
                        @if (isset($export->parent_designation))
                            <td>{{$row['parent_designation_name']}}</td>
                        @endif
                        @if (isset($export->caste))
                            <td>{{$row['caste_name']}}</td>
                        @endif
                        @if (isset($export->religion))
                            <td>{{$row['religion_name']}}</td>
                        @endif
                        @if (isset($export->mother_toungue))
                            <td>{{$row['mother_tounge']}}</td>
                        @endif
                        @if (isset($export->mobile))
                            <td>{{phone_number($row['mobile_phone'])}}</td>
                        @endif
                        @if (isset($export->address1))
                            <td>{{$row['address1']}}</td>
                        @endif
                        @if (isset($export->address2))
                            <td>{{$row['address2']}}</td>
                        @endif
                        @if (isset($export->city))
                            <td>{{$row['city_name']}}</td>
                        @endif
                        @if (isset($export->postal_code))
                            <td>{{$row['postal_code']}}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </body>
</html>
