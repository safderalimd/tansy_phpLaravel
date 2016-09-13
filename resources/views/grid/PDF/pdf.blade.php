<!DOCTYPE html>
<html>
<head>
    <title>{{$grid->screenName}} Report</title>
    @include('reports.common.bootstrap')
    @include('reports.common.css')
    <?php
        $columns = $grid->columns();
        $buttons = $grid->buttons();
    ?>
    <style type="text/css">
        @if (count($columns) > 25)
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
        @elseif (count($columns) > 20)
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
    <div id="watermark"><div id="watermark-text">{{$grid->organizationName()}}</div></div>

    <div class="container">

        @include('reports.common.pdf-header', [
            'school' => $grid->organizationName(),
            'phone'  => $grid->organizationPhone(),
        ])

        @include('reports.common.report-name', ['report' => $grid->screenName])

        @foreach ($grid->filters as $filter)
            <?php
                $filterName = 'f' . $filter->id();
                $filterValue = isset($grid->{$filterName}) ? $grid->{$filterName} : '';
            ?>
            @if ($filter->isDateInput())
                <div class="row">
                    <div class="col-md-12"><h4>{{$filter->label()}}: {{style_date($filterValue)}} </h4></div>
                </div>

            @elseif ($filter->isDropDown())
                <div class="row">
                    <?php
                        foreach($grid->filterDropdownValues($filter) as $option) {
                            if (!isset($option['drop_down_filter_id']) || !isset($option['drop_down_list_name'])) {
                                continue;
                            }

                            if ($filterValue == $option['drop_down_filter_id']) {
                                $filterValue = $option['drop_down_list_name'];
                                break;
                            }
                        }
                    ?>
                    <div class="col-md-12"><h4>{{$filter->label()}}: {{$filterValue}} </h4></div>
                </div>
            @endif
        @endforeach

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
                @include('grid.table')
            </div>
        </div>

    </div>

</body>
</html>
