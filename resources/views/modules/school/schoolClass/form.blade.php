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
                          action="@if($model->isNewRecord()){{ url("/cabinet/class/create")}} @else {{url("/cabinet/class/edit/{$model->getID()}")}} @endif"
                          method="POST">
                        {{ csrf_field() }}
         

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="activeRow" @if($model->activeRow) checked @endif> Active ?
                                    </label>
                                </div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-2 control-label" for="name">SchoolClass Name</label>
                            <div class="col-md-10">
                                <input id="SchoolClassName" class="form-control" type="text" name="SchoolClassName"
                                       value="@if(!empty($model->SchoolClassName)){!!$model->SchoolClassName!!}@else{{ old('SchoolClassName') }}@endif"
                                       placeholder="SchoolClassName">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="facility">Class Group</label>
                            <div class="col-md-10">
                                <select id="ClassGroup" class="form-control" name="ClassGroup[]">
                                    @foreach($ClassGroup as $item)
                                        @if(!empty(old('ClassGroup')))
                                            <option @if ($item['class_group_entity_id'] == old('ClassGroup')[0]) selected @endif value="{!!$item['class_group_entity_id']!!}">{!!$item['class_group']!!}</option>
                                        @else
                                            <option @if (!$model->isNewRecord() && in_array($item['class_group_entity_id'], $model->getClassGroups())) selected @endif value="{!!$item['class_group_entity_id']!!}">{!!$item['class_group']!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="facility">Class Category</label>
                            <div class="col-md-10">
                                <select id="ClassCategory" class="form-control" name="ClassCategory[]">
                                    @foreach($ClassCategory as $item)
                                        @if(!empty(old('ClassCategory')))
                                            <option @if ($item['class_category_entity_id'] == old('ClassCategory')[0]) selected @endif value="{!!$item['class_category_entity_id']!!}">{!!$item['class_category']!!}</option>
                                        @else
                                            <option @if (!$model->isNewRecord() && in_array($item['class_category_entity_id'], $model->getClassCategorys())) selected @endif value="{!!$item['class_category_entity_id']!!}">{!!$item['class_category']!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="name">Reporting Order</label>
                            <div class="col-md-10">
                                <input id="ReportingOrder" class="form-control" type="text" name="ReportingOrder"
                                       value="@if(!empty($model->SchoolClassName)){!!$model->ReportingOrder!!}@else{{ old('ReportingOrder') }}@endif"
                                       placeholder="ReportingOrder">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="facility">Facility</label>
                            <div class="col-md-10">
                                <select id="facility" class="form-control" name="facilityID">
                                    @foreach($facility as $item)
                                        @if(!empty(old('facilityID')))
                                            <option @if ($item['facility_entity_id'] == old('facilityID')) selected @endif value="{!!$item['facility_entity_id']!!}">{!!$item['facility_name']!!}</option>
                                        @else
                                            <option @if (!$model->isNewRecord() && in_array($item['facility_entity_id'], $model->getFacilitates())) selected @endif value="{!!$item['facility_entity_id']!!}">{!!$item['facility_name']!!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <button class="btn btn-block btn-primary" type="submit">Submit</button>
                        <a href="{{ url("/cabinet/class")}}" class="btn btn-default btn-block">Back to list</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection