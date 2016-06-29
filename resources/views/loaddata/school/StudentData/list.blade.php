@extends('layout.cabinet')

@section('title', 'Student Data Load')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Data Load</h3>
        </div>
        <div class="panel-body">
            @include('commons.errors')

            <form class="form-horizontal" id="load-data-form" accept-charset="UTF-8" action="{{ form_action() }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="col-md-1 control-label" for="facility_entity_id">Facility</label>
                    <div class="col-md-3">
                        <select id="facility_entity_id" class="form-control" name="facility_entity_id">
                            <option value="none">Select a facility..</option>
                            @foreach($studentData->facilities() as $option)
                                <option value="{{ $option['facility_entity_id'] }}">{{ $option['facility_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="class_entity_id">Class</label>
                    <div class="col-md-3">
                        <select id="class_entity_id" class="form-control" name="class_entity_id">
                            <option value="none">Select a class..</option>
                            @foreach($studentData->classes() as $option)
                                <option value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label">Excel File</label>
                    <div class="col-md-10">
                        <label class="btn btn-default btn-file">
                            Choose File...
                            {!! Form::file('attachment', array('class'=>'form-control')) !!}
                        </label>
                        <span class="file-name"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-2 col-md-offset-1">
                        <button class="btn btn-primary" type="submit">Load Data</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
            $('.file-name').text(label);
            $('#load-data-form').valid();
        });
    });

    $('#load-data-form').submit(function() {
        if (! $('#load-data-form').valid()) {
            return false;
        }

        if ($('#facility_entity_id option:selected').val() == 'none') {
            alert('Please select a facility.');
            return false;
        }

        return true;
    });

    $('#load-data-form').validate({
        rules: {
            facility_entity_id: {
                requiredSelect: true
            },
            class_entity_id: {
                requiredSelect: true
            },
            attachment: {
                required: true
            }
        }
    });
</script>
@endsection

