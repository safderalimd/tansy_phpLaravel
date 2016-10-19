@extends('layout.cabinet')

@section('title', 'DICE')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>DICE</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" target="_blank" id="generate-report-form" action="/cabinet/pdf---dice/pdf" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">

                <div class="row">
                    <div class="col-md-3">
                        <button id="generate-report" class="btn btn-primary" type="submit">Generate PDF Report</button>
                    </div>
                </div>
            </form>

            <br/>

            <form class="form-horizontal" target="_blank" action="/cabinet/pdf---dice/csv" method="GET">
                <input type="hidden" id="random_id" name="ri" value="1">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-default" type="submit">Generate CSV</button>
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
