@extends('layout.cabinet')

@section('title', $grid->screenName)

@section('content')

<?php

    $columns = $grid->columns();
    $buttons = $grid->buttons();

?>

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>{{$grid->screenName}}</h3>
            @if ($grid->settings->hasInsertButton())
                <a href="{{url(app('request')->path() . '/create')}}" class="btn pull-right btn-default">Add new record</a>
            @endif
        </div>
        <div class="panel-body">

            @include('commons.errors')

            @if (isset($options['beforeGridInclude'])) @include($options['beforeGridInclude']) @endif


@foreach ($grid->filters as $filter)
    {{-- todo: check not hidden filter --}}
    @if ($filter->isDateInput())

    <div class="row">
        <div class="col-md-12">
            <div class="form-group dynamic-filter">
                <label class="control-label dynamic-filter-label" for="filter_{{$filter->id()}}">{{$filter->label()}}</label>
                <div class="dynamic-filter-item">
                    @if ($filter->isDateInput())
                    <div class="input-group date">
                        <input id="filter_{{$filter->id()}}" data-type="value" data-filterId="f{{$filter->id()}}" class="dynamic-filter-input form-control" type="text" name="filter_{{$filter->id()}}" value="{{queryStringValue('f'.$filter->id())}}" placeholder="{{$filter->label()}}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-calendar"></span></button>
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @endif
@endforeach

            <table id="grid-table" class="table table-striped table-bordered table-hover" @if (!isset($options['datatableOff'])) data-dynamicgrid @endif>
                <thead>
                    <tr>
                        @if (isset($options['headerFirstInclude'])) @include($options['headerFirstInclude']) @endif
                        @foreach ($columns as $column)
                            <th>
                                {{ $column->label() }}
                                @if ($column->isSortable())
                                    <i class="sorting-icon glyphicon glyphicon-chevron-down"></i>
                                @endif
                            </th>
                        @endforeach

                        @if (count($buttons))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($grid->rows() as $row)
                    <tr>

                    @if (isset($options['rowFirstInclude'])) @include($options['rowFirstInclude'], ['row' => $row]) @endif

                    @foreach($columns as $column)
                        <td>
                        @if (isset($row[$column->name()]))
                            @if ($column->hasMobileFormat())
                                {{ phone_number($row[$column->name()]) }}

                            @elseif ($column->hasDateFormat())
                                {{ style_date($row[$column->name()]) }}

                            @elseif ($column->hasCurrencyFormat())
                                &#x20b9; {{ amount($row[$column->name()]) }}

                            @elseif ($column->hasNumberFormat())
                                {{ nr($row[$column->name()]) }}

                            @elseif ($column->hasLinkFormat())
                                <a href="{{ $column->link($row) }}" title="{{ $row[$column->name()] }}">{{ $row[$column->name()] }}</a>

                            @else
                                {{ $row[$column->name()] }}

                            @endif
                        @endif
                        </td>
                    @endforeach

                    @if (count($buttons))
                    <td>
                        @foreach ($buttons as $buttonColumn)
                        @foreach ($buttonColumn->getButtons() as $button)
                            <?php
                                $rowLabel = isset($button['label']) ? $button['label'] : null;
                                $rowLink  = isset($row[$button['link']]) ? $row[$button['link']] : null;
                                $rowLabel = trim(ucfirst(strtolower($rowLabel)));
                                $rowLink = '/' . ltrim($rowLink, '/');
                            ?>
                            @if ($rowLabel == 'Edit')
                                <a class="btn btn-default" href="{{url($rowLink)}}" title="Edit">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>

                            @elseif ($rowLabel == 'Delete')
                                <a class="btn btn-default formConfirm" href="{{url($rowLink)}}"
                                   title="Delete"
                                   data-title="Delete {{$grid->screenName}}"
                                   data-message="Are you sure to delete the selected record?"
                                >
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            @else
                                <a class="btn btn-default" href="{{url($rowLink)}}" title="{{$rowLabel}}">{{$rowLabel}}</a>

                            @endif
                        @endforeach
                        @endforeach
                    </td>
                    @endif

                    </tr>

                @endforeach
                </tbody>
            </table>

            @include('commons.modal')

        </div>
    </div>
</div>
@if (isset($options['afterGridInclude'])) @include($options['afterGridInclude']) @endif
@endsection

@section('scripts')
@if (isset($options['scriptsInclude'])) @include($options['scriptsInclude']) @endif
<script type="text/javascript">

    @if ($grid->settings->showSearchBox() && !isset($options['datatableOff']))
        $('table[data-dynamicgrid]').DataTable({
            "aaSorting": [],
            "autoWidth": false
        });
    @endif

    $('.dynamic-filter-input').change(function() {
        updateDynamicFilterQueryString();
    });

    function updateDynamicFilterQueryString() {
        window.location.href = window.location.href.split('?')[0] + getDynamicFilterQueryString();
    }

    // get the query string
    function getDynamicFilterQueryString() {

        var items = [];

        $('.dynamic-filter-input').each(function() {
            var filter = $(this).attr('data-filterId') + '=';
            if ($(this).attr('data-type') == 'value' && $(this).val()) {
                items.push(filter+$(this).val());
            }
        });

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

</script>
@endsection
