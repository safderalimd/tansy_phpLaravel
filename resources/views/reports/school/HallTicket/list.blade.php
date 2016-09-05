@extends('layout.cabinet')

@section('title', 'PDF - Hall Ticket')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>PDF - Hall Ticket</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form id="generate-report-form" class="form-horizontal" action="/cabinet/pdf---hall-ticket/pdf" target="_blank" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="form-group">
                    <label class="col-md-1 control-label" for="aei">Account Type</label>
                    <div class="col-md-3">
                        <select id="aei" class="form-control" name="aei">
                            <option value="none">Select an account..</option>
                            @foreach($report->schoolAccountTypeFilter() as $option)
                                <option value="{{ $option['entity_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="eid">Exam</label>
                    <div class="col-md-3">
                        <select id="eid" class="form-control" name="eid">
                            <option value="none">Select an exam..</option>
                            @foreach($report->mainExam() as $option)
                                <option value="{{ $option['exam_entity_id'] }}">{{ $option['exam'] }}</option>
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

        $('#random_id').val(Date.now());
        return true;
    });

    $('#generate-report-form').validate({
        rules: {
            aei: {
                requiredSelect: true
            },
            eid: {
                requiredSelect: true
            }
        }
    });
</script>
@endsection
