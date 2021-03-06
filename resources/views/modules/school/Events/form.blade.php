@extends('layout.cabinet')

@section('title', 'Events')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Events{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form id="events-form" class="form-horizontal" action="{{ form_action_full() }}" method="POST">
                        {{ csrf_field() }}

               			<div class="form-group">
                            <label class="col-md-4 control-label required" for="event_name">Event Name</label>
                            <div class="col-md-8">
                                <input id="event_name" class="form-control" type="text" name="event_name" value="{{ v('event_name') }}" placeholder="Event Name">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'    => 'Exam Type' ,
                            'name'     => 'event_type_id',
                            'options'  => $events->eventTypes(),
                            'keyId'    => 'event_type_id',
                            'keyName'  => 'event_type',
                            'none'     => 'Select an event type..',
                            'required' => true,
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="start_date">Start Date</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <input id="start_date" class="form-control" type="text" name="start_date" value="{{ v('start_date') }}" placeholder="Start Date">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label required" for="end_date">End Date</label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <input id="end_date" class="form-control" type="text" name="end_date" value="{{ v('end_date') }}" placeholder="End Date">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span
                                                    class="glyphicon glyphicon-calendar"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="description">Description</label>
                            <div class="col-md-8">
                                <textarea rows="5" id="description" class="form-control" name="description" placeholder="Description">{{ v('description') }}</textarea>
                            </div>
                        </div>

                        <div class="row grid_footer">
                           <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/events").query_string()}}" class="btn btn-default cancle_btn">Cancel</a>
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

    $('#events-form').validate({
        rules: {
            event_name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            event_type_id: {
                requiredSelect: true
            },
            start_date: {
                required: true,
                dateISO: true
            },
            end_date: {
                required: true,
                dateISO: true
            }
        }
    });

    $('#start_date').change(function() {
        $('#start_date').valid();
    });

    $('#end_date').change(function() {
        $('#end_date').valid();
    });

</script>
@endsection
