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
            @if (isset($options['headerLastInclude'])) @include($options['headerLastInclude']) @endif
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

        @if (isset($options['rowLastInclude'])) @include($options['rowLastInclude'], ['row' => $row]) @endif

        </tr>

    @endforeach
    </tbody>
</table>
