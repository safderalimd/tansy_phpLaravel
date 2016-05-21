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

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="col-md-4">
                            <select id="primary_key_id" class="form-control" name="primary_key_id">
                                @foreach($export->dropdown() as $option)
                                    <option data-rowType="{{$option['row_type']}}" {{ s('primary_key_id', $option['primary_key_id']) }} value="{{ $option['primary_key_id'] }}">{{ $option['drop_down_list_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button id="generate-report" data-loading-text="<span class='glyphicon glyphicon-refresh spinning'></span> Generating Report..." class="btn btn-primary" type="submit">Generate Report</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report').click(function() {

        $('#generate-report').prop('disabled', true);
        $('#generate-report').button('loading');

        var primaryKeyId = $('#primary_key_id option:selected').val();
        var rowType = $('#primary_key_id option:selected').attr('data-rowType');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "/cabinet/student-export",
            data: {_token: CSRF_TOKEN, primary_key_id: primaryKeyId, row_type: rowType},
            dataType: "json",
            success: function(data) {
                console.log(data);
            }
        });

    });

</script>
@endsection
