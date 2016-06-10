@extends('layout.cabinet')

@section('title', 'Daily Collection')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Daily Collection</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" id="generate-report-form" action="/cabinet/pdf---daily-collection/pdf" target="_blank" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="form-group">
                    <label class="col-md-1 control-label" for="start">Start Date</label>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <input id="start" class="form-control" type="text" name="start" value="" placeholder="Start Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="end">End Date</label>
                    <div class="col-md-3">
                        <div class="input-group date">
                            <input id="end" class="form-control" type="text" name="end" value="" placeholder="End Date">
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

</script>
@endsection
