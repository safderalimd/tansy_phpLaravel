@extends('layout.cabinet')

@section('title', 'School Class')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>School Class</h3>
					@if(Request::segment(3) == "edit")
						<label>- Update</label>
					@else
						<label>- Add New Record</label>
					@endif
                </div>

                <div class="panel-body edit_form_wrapper">

                    @include('commons.errors')

                    <form class="form-horizontal"
                          action="@if($model->isNewRecord()){{ url("/cabinet/class/create")}} @else {{url("/cabinet/class/edit/{$model->getID()}")}} @endif"
                          method="POST">
                        {{ csrf_field() }}

                        <section class="form_panel">
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>

									{!! Form::checkbox('activeRow', old('activeRow'), $model->activeRow) !!} Active
                                    </label>
                                </div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-4 control-label" for="name">SchoolClass Name</label>
                            <div class="col-md-8">
                                <input id="SchoolClassName" class="form-control" type="text" name="SchoolClassName"
                                       value="@if(!empty($model->SchoolClassName)){!!$model->SchoolClassName!!}@else{{ old('SchoolClassName') }}@endif"
                                       placeholder="SchoolClassName">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="facility">Class Group</label>
                            <div class="col-md-8">
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
                            <label class="col-md-4 control-label" for="facility">Class Category</label>
                            <div class="col-md-8">
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
                            <label class="col-md-4 control-label" for="name">Reporting Order</label>
                            <div class="col-md-8">
                                <input id="ReportingOrder" maxlength="3" class="form-control" type="text" name="ReportingOrder"
                                       value="@if(!empty($model->SchoolClassName) && null == old('ReportingOrder')){!!$model->ReportingOrder!!}@else{{ old('ReportingOrder') }}@endif"
                                       placeholder="ReportingOrder"><span id="errmsg"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="facility">Facility</label>
                            <div class="col-md-4">
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
                        </section>
						<div class="row_footer">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/class")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
// validation, to include only digits
$(document).ready(function () {
    $("#ReportingOrder").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
});
</script>
@endsection
