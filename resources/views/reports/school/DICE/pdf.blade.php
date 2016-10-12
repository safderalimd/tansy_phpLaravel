<!DOCTYPE html>
<html>
    <head>
        <title>DICE</title>
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
        $dice = $export->dice();
    ?>

    <div class="container">

        <strong>

            @include('reports.common.pdf-header', [
                'school' => $export->organizationName(),
                'line2'  => $export->organizationLine2(),
                'line3'  => $export->organizationLine3(),
            ])

            @include('reports.common.report-name', ['report' => $export->reportName])
        </strong>

        <?php 
            $firstRow = $dice->first();
            $headerRow = $firstRow->groupBy('measure_type');
        ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td class="text-center" rowspan="2">Class</td>
                    @foreach ($headerRow as $cell => $subTypes) 
                        <td class="text-center" colspan="{{count($subTypes)}}">{{$cell}}</td>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($headerRow as $cell => $subTypes) 
                        @foreach ($subTypes as $subType)
                            <td class="text-center">{{$subType['measure_sub_type']}}</td>
                        @endforeach                        
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dice as $diceRow) 
                    <tr>
                        <?php 
                            $row = $diceRow->groupBy('measure_type'); 
                            $className = $row->first()->first()['class_name'];
                        ?>
                        <td class="text-center">{{$className}}</td>
                        @foreach ($row as $cell => $subTypes) 
                            @foreach ($subTypes as $subType) 
                                <td class="text-center">{{$subType['student_count']}}</td>
                            @endforeach
                        @endforeach
                    </tr>                
                @endforeach
            </tbody>
        </table>

    </div>
    </body>
</html>
