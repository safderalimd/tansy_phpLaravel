@foreach ($grid->filters as $filter)
    {{-- todo: check not hidden filter --}}
    @if ($filter->isDateInput())

    <div class="row">
        <div class="col-md-12">
            <div class="form-group dynamic-filter">
                <label class="control-label dynamic-filter-label" for="f{{$filter->id()}}">{{$filter->label()}}</label>
                <div class="dynamic-filter-item">
                    @if ($filter->isDateInput())
                    <div class="input-group date">
                        <input required id="f{{$filter->id()}}" data-type="value" data-filterId="f{{$filter->id()}}" class="dynamic-filter-input form-control" type="text" name="f{{$filter->id()}}" value="{{queryStringValue('f'.$filter->id())}}" placeholder="{{$filter->label()}}">
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
