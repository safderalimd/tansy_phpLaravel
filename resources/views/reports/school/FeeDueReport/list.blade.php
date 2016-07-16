@extends('layout.cabinet')

@section('title', 'PDF - Due Report')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>PDF - Due Report</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form id="generate-report-form" class="form-horizontal" action="/cabinet/pdf---due-report/pdf" target="_blank" method="GET">
                <input type="hidden" id="row_type" name="rt" value="">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="form-group">
                    <label class="col-md-1 control-label" for="primary_key_id">Account Type</label>
                    <div class="col-md-3">
                        <select id="primary_key_id" class="form-control" name="pk">
                            <option data-rowType="none" value="none">Select an account..</option>
                            @foreach($report->accountsDropdown() as $option)
                                <option data-rowType="{{$option['row_type']}}" value="{{ $option['primary_key_id'] }}">{{ $option['drop_down_list_name'] }}</option>
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

        var rowType = $('#primary_key_id option:selected').attr('data-rowType');
        var primaryKeyId = $('#primary_key_id option:selected').val();
        if (primaryKeyId == 'none') {
            alert('Please select an account type.');
            return false;
        }
        $('#row_type').val(rowType);
        $('#random_id').val(Date.now());
        return true;
    });

    $('#generate-report-form').validate({
        rules: {
            pk: {
                requiredSelect: true
            }
        }
    });
</script>
@endsection
