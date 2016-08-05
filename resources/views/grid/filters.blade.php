@foreach ($grid->filters as $filter)
    @if ($filter->isDateInput())
        <div class="row">
            <div class="col-md-12">
                <div class="form-group dynamic-filter">
                    <label class="control-label dynamic-filter-label" for="f{{$filter->id()}}">{{$filter->label()}}</label>
                    <div class="dynamic-filter-item">
                        <div class="input-group date">
                            <input required id="f{{$filter->id()}}" data-type="value" data-filterId="f{{$filter->id()}}" class="dynamic-filter-input form-control" type="text" name="f{{$filter->id()}}" value="{{queryStringValue('f'.$filter->id())}}" placeholder="{{$filter->label()}}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif ($filter->isDropDown())

        <div class="row">
            <div class="col-md-12">
                <div class="form-group dynamic-filter">
                    <label class="control-label dynamic-filter-label" for="f{{$filter->id()}}">{{$filter->label()}}</label>
                    <div class="dynamic-filter-item">
                        <select data-filterId="f{{$filter->id()}}" data-type="dropdown" requiredSelect id="f{{$filter->id()}}" class="dynamic-filter-input form-control" name="f{{$filter->id()}}">
                            <option value="none">Select an option..</option>
                            @foreach($grid->filterDropdownValues($filter) as $option)
                                @if (isset($option['drop_down_filter_id']) && isset($option['drop_down_list_name']))
                                    <option {{activeSelect($option['drop_down_filter_id'], 'f'.$filter->id())}} value="{{ $option['drop_down_filter_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endforeach
