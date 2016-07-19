@extends('layout.cabinet')

@section('title', $grid->screenName)

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>{{$grid->screenName}}</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

@foreach ($grid->filters as $filter)
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
@endforeach

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
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

@endsection

@section('scripts')
<script type="text/javascript">

    $('.dynamic-filter-input').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {

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
