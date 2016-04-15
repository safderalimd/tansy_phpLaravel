@extends('layout.cabinet')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal"
                          action="@if($model->isNewRecord()){{ url("/cabinet/fiscalYear/create")}} @else {{url("/cabinet/fiscalYear/edit/{$model->getID()}")}} @endif"
                          method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">Fiscal Year</label>
                            <div class="col-md-10">
                                <input id="name" class="form-control" type="text" name="name" value="{!!$model->name!!}"
                                       placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="startDate">Start Date</label>
                            <div class="col-md-10">
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
                            <div class="col-md-10">
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
                            <div class="col-md-10">
                                <select id="facility" multiple class="form-control" name="facility[]">
                                    @foreach($facility as $item)
                                        <option @if (!$model->isNewRecord() && in_array($item['facility_entity_id'], $model->getFacilitates())) selected @endif value="{!!$item['facility_entity_id']!!}">{!!$item['facility_name']!!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="currentFiscalYear" value="1" @if($model->currentFiscalYear) checked @endif> Current year?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary" type="submit">Submit</button>
                        <a href="{{ url("/cabinet/fiscalYear")}}" class="btn btn-default btn-block">Back to list</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection