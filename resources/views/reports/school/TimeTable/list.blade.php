@extends('layout.cabinet')

@section('title', 'Time Table')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Time Table</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" target="_blank" id="generate-report-form" action="/cabinet/pdf---time-table/pdf" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="account_type_entity_id">Account Type</label>
                            <div class="col-md-8">
                                <select id="account_type_entity_id" class="form-control" name="aei">
                                    <option value="none">Select an account type..</option>
                                    @foreach($export->schoolAccountTypeFilter() as $option)
                                        <option value="{{$option['entity_id']}}">{{$option['drop_down_list_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="start_date">Week Date</label>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <input id="start_date" class="form-control" type="text" name="dt" value="" placeholder="Week Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
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
        $('#random_id').val(Date.now());
        return true;
    });

    $('#move-students-form').validate({
        rules: {
            account_type_entity_id: {
                requiredSelect: true
            },
            start_date: {
                required: true
            }
        }
    });
</script>
@endsection
