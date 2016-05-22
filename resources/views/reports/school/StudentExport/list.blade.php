@extends('layout.cabinet')

@section('title', 'Student Export')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Export</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" id="generate-report-form" action="/cabinet/student-export/pdf" target="_blank" method="GET">
                <input type="hidden" id="row_type" name="rt" value="">
                <input type="hidden" id="random_id" name="ri" value="">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-md-4">
                                <select id="primary_key_id" class="form-control" name="pk">
                                    @foreach($export->dropdown() as $option)
                                        <option data-rowType="{{ $option['row_type'] }}" value="{{ $option['primary_key_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button id="generate-report" class="btn btn-primary" type="submit">Generate Report</button>
                            </div>
                        </div>
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
        var rowType = $('#primary_key_id option:selected').attr('data-rowType');
        var primaryKeyId = $('#primary_key_id option:selected').val();
        if (primaryKeyId == '') {
            var primaryKeyId = $('#primary_key_id option:selected').val(0);
        }
        $('#row_type').val(rowType);
        $('#random_id').val(Date.now());
        return true;
    });

</script>
@endsection
