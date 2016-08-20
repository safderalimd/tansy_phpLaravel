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

            @if (!isset($options['skipGridFilters']))
                @include('grid.filters')
            @endif

            @include('grid.table')

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
            var dataType = $(this).attr('data-type');

            if (dataType == 'value' && $(this).val()) {
                items.push(filter+$(this).val());
            } else if (dataType == 'dropdown') {
                var option = $('option:selected', $(this)).val();
                if (option != 'none') {
                    items.push(filter+option);
                }
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
