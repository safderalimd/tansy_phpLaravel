@extends('layout.cabinet')

@section('title', 'Fiscal Year')

@section('content')


<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-th"></i>
                <h3>Fiscal Year</h3>
                @if(Request::segment(3) == "edit")
                    <label>- Update</label>
                @else
                    <label>- Add New Record</label>
                @endif
            </div>

            <div class="panel-body edit_form_wrapper">

                @include('commons.errors')

                <form class="form-horizontal"
                      action="@if($model->isNewRecord()){{ url("/cabinet/fiscal-year/create")}} @else {{url("/cabinet/fiscal-year/edit/{$model->getID()}")}} @endif"
                      method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">Fiscal Year</label>
                        <div class="col-md-6">
                            <input id="name" class="form-control" type="text" name="name" value="{!!$model->name!!}"
                                   placeholder="Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="startDate">Start Date</label>
                        <div class="col-md-6">
                            <div class="input-group date">
                                <input id="startDate" class="form-control" type="text" name="startDate"
                                       value="{!!$model->startDate!!}" placeholder="Start Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span
                                                class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="endDate">End Date</label>
                        <div class="col-md-6">
                            <div class="input-group date">
                                <input id="endDate" class="form-control" type="text" name="endDate"
                                       value="{!!$model->endDate!!}" placeholder="End Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span
                                                class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="facility">Facility</label>
                        <div class="col-md-8">
                            <select id="facility" multiple class="form-control" name="facility[]">
                                @foreach($facility as $item)
                                    <option @if (!$model->isNewRecord() && in_array($item['facility_entity_id'], $model->getFacilitates())) selected @endif value="{!!$item['facility_entity_id']!!}">{!!$item['facility_name']!!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-5">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="currentFiscalYear" value="1" @if($model->currentFiscalYear) checked @endif> Current year?
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row_footer">
                       <div class="col-md-12 text-center grid_footer">
                            <button class="btn btn-primary grid_btn" type="submit">Save</button>
                            <a href="{{ url("/cabinet/fiscal-year")}}" class="btn btn-default cancle_btn">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
