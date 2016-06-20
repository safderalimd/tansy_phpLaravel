@extends('layout.cabinet')

@section('title', 'Exam')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Exam{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="exam-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        @if($exam->isNewRecord())
                                            <input checked="checked" name="active" type="checkbox" disabled readonly> Active
                                        @else
                                            <input {{ c('active') }} name="active" type="checkbox"> Active
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-4 control-label required" for="exam_name">Exam</label>
                            <div class="col-md-8">
                                <input id="exam_name" class="form-control" type="text" name="exam_name" value="{{ v('exam_name') }}" placeholder="Exam">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Exam Type' ,
                            'name'     => 'exam_type_id',
                            'options'  => $exam->examTypes(),
                            'keyId'    => 'exam_type_id',
                            'keyName'  => 'exam_type',
                            'none'     => 'Select an exam type..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="facility_ids">Facility</label>
                            <div class="col-md-8">
                                <?php
                                    if (!is_array($exam->selectedFacilities)) {
                                        $exam->selectedFacilities = [];
                                    }
                                ?>
                                <select id="facility_ids" class="form-control" name="facility_ids">
                                    <option value="none">Select a facility..</option>
                                    @foreach($exam->facilities() as $option)
                                        <option @if(in_array($option['facility_entity_id'], $exam->selectedFacilities)) selected @endif value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
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
                            <label class="col-md-4 control-label required" for="progress_card_reporting_order">Card Reporting Order</label>
                            <div class="col-md-8">
                                <input id="progress_card_reporting_order" class="form-control" type="text" name="progress_card_reporting_order" value="{{ v('progress_card_reporting_order') }}" placeholder="Card Reporting Order">
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/exam")}}" class="btn btn-default cancle_btn">Cancel</a>
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

    $('#exam-form').validate({
        rules: {
            exam_name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            exam_type_id: {
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
            progress_card_reporting_order: {
                required: true,
                number: true,
                min: 0,
                max:999
            }
        }
    });

</script>
@endsection
