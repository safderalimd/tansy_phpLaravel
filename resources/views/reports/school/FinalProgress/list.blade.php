@extends('layout.cabinet')

@section('title', 'Final Progress')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Final Progress</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" id="generate-report-form" action="/cabinet/pdf---student-final-progress/pdf" target="_blank" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">
                <input type="hidden" id="row_type" name="rt" value="">

                <div class="form-group">
                    <label class="col-md-1 control-label">Account</label>
                    <div class="col-md-3">
                        <select id="class_entity_id" class="form-control" name="ei">
                            <option value="none">Select an account..</option>
                            @foreach($export->accountTypeFilter() as $option)
                                <option data-rowType="{{$option['row_type']}}" value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <button id="generate-report" class="btn btn-primary" type="submit">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report-form').submit(function() {
        if (! $('#generate-report-form').valid()) {
            return false;
        }

        if ($('#class_entity_id option:selected').val() == 'none') {
            alert('Please select an option.');
            return false;
        }

        $('#random_id').val(Date.now());
        $('#row_type').val($('#class_entity_id option:selected').attr('data-rowType'));
        return true;
    });

    $('#generate-report-form').validate({
        rules: {
            ei: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection
