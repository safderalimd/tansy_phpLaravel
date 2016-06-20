@extends('layout.cabinet')

@section('title', 'Subject')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Subject{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="class-subject-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        @if($subject->isNewRecord())
                                            <input checked="checked" name="active" type="checkbox" disabled readonly> Active
                                        @else
                                            <input {{ c('active') }} name="active" type="checkbox"> Active
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-4 control-label required" for="subject_name">Subject</label>
                            <div class="col-md-8">
                                <input id="subject_name" class="form-control" type="text" name="subject_name" value="{{ v('subject_name') }}" placeholder="Subject">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Subject Type' ,
                            'name'     => 'subject_type_id',
                            'options'  => $subject->subjectTypes(),
                            'keyId'    => 'subject_type_id',
                            'keyName'  => 'subject_type',
                            'none'     => 'Select a subject type..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="facility_ids">Facility</label>
                            <div class="col-md-8">
                                <?php
                                    if (!is_array($subject->selectedFacilities)) {
                                        $subject->selectedFacilities = [];
                                    }
                                ?>
                                <select id="facility_ids" class="form-control" name="facility_ids">
                                    <option value="none">Select a facility..</option>
                                    @foreach($subject->facilities() as $option)
                                        <option @if(in_array($option['facility_entity_id'], $subject->selectedFacilities)) selected @endif value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="reporting_order">Reporting Order</label>
                            <div class="col-md-8">
                                <input id="reporting_order" class="form-control" type="text" name="reporting_order" value="{{ v('reporting_order') }}" placeholder="Reporting Order">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="subject_short_code">Short Code</label>
                            <div class="col-md-8">
                                <input id="subject_short_code" class="form-control" type="text" name="subject_short_code" value="{{ v('subject_short_code') }}" placeholder="Short Code">
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/subject")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript">

    $('#class-subject-form').validate({
        rules: {
            subject_name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            subject_type_id: {
                requiredSelect: true
            },
            facility_ids: {
                requiredSelect: true
            },
            reporting_order: {
                required: true,
                number: true,
                min: 0
            },
            subject_short_code: {
                required: true,
                maxlength: 15
            }
        }
    });

</script>
@endsection
