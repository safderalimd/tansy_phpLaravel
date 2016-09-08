@extends('layout.cabinet')

@section('title', 'Homework')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Homework{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="homework-form" class="form-horizontal" action="{{ form_action_full() }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="class_entity_id">Class</label>
                            <div class="col-md-8">
                                <select @if (!$homework->isNewRecord()) disabled="disabled" @endif id="class_entity_id" class="form-control" name="class_entity_id">
                                    <option value="none">Select a class..</option>
                                    @foreach($homework->classes() as $option)
                                        @if ($homework->isNewRecord())
                                            <option {{ activeSelect($option['class_entity_id'], 'cei') }} value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                                        @else
                                            <option {{ s('class_entity_id', $option['class_entity_id']) }} value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="subject_entity_id">Subject</label>
                            <div class="col-md-8">
                                <select @if (!$homework->isNewRecord()) disabled="disabled" @endif id="subject_entity_id" class="form-control" name="subject_entity_id">
                                    <option value="none">Select a subject..</option>
                                    @foreach($homework->subject() as $option)
                                        @if ($homework->isNewRecord())
                                            <option {{ activeSelect($option['subject_entity_id'], 'sei') }} value="{{ $option['subject_entity_id'] }}">{{ $option['subject'] }}</option>
                                        @else
                                            <option {{ s('subject_entity_id', $option['subject_entity_id']) }} value="{{ $option['subject_entity_id'] }}">{{ $option['subject'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="home_work_date">Homework Date</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <input id="home_work_date" class="form-control" type="text" name="home_work_date" value="{{v('home_work_date')}}" placeholder="Homework Date">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>

               			<div class="form-group">
                            <label class="col-md-4 control-label required" for="home_work">Homework</label>
                            <div class="col-md-8">
                                <textarea placeholder="Homework" rows="7" id="home_work" name="home_work" class="form-control">{{ v('home_work') }}</textarea>
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-offset-4 col-md-8">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/homework").query_string()}}" class="btn btn-default cancle_btn">Cancel</a>
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

    $('#homework-form').validate({
        rules: {
            class_entity_id: {
                requiredSelect: true
            },
            subject_entity_id: {
                requiredSelect: true
            },
            home_work_date: {
                required: true,
                dateISO: true
            },
            home_work: {
                required: true
            }
        }
    });

</script>
@endsection
