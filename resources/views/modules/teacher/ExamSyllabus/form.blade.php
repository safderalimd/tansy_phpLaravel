@extends('layout.cabinet')

@section('title', 'Exam Syllabus')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Exam Syllabus{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="exam-syllabus-form" class="form-horizontal" action="{{ form_action_full() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Class Name</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$syllabus->class_name}}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Main Exam Name</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$syllabus->main_exam_name}}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Sub Exam Name</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$syllabus->sub_exam_name}}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Subject</label>
                            <div class="col-md-8">
                                <div class="well well-sm">{{$syllabus->subject}}</div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-4 control-label required" for="exam_syllabus">Exam Syllabus</label>
                            <div class="col-md-8">
                                <textarea placeholder="Exam Syllabus" rows="7" id="exam_syllabus" name="exam_syllabus" class="form-control">{{ v('syllabus') }}</textarea>
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-offset-4 col-md-8">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/exam-syllabus").query_string()}}" class="btn btn-default cancle_btn">Cancel</a>
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

    // $('#exam-syllabus-form').validate({
    //     rules: {
    //         class_entity_id: {
    //             requiredSelect: true
    //         },
    //         subject_entity_id: {
    //             requiredSelect: true
    //         },
    //         home_work_date: {
    //             required: true,
    //             dateISO: true
    //         },
    //         home_work: {
    //             required: true
    //         }
    //     }
    // });

</script>
@endsection
