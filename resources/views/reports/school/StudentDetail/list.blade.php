@extends('layout.cabinet')

@section('title', 'Student Detail')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Detail</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" target="_blank" id="generate-report-form" action="/cabinet/pdf---student-detail/pdf" method="GET">
                <input type="hidden" id="random_id" name="ri" value="">
                <input type="hidden" id="report_type" name="rt" value="pdf">

                @include('grid.filters')

                <div class="row">
                    <div class="col-md-12" style="padding-left:200px;">

                        <div class="checkbox">
                            <label><input type="checkbox" id="toggle-subjects" name="toggle_checkbox" value=""> Check All</label>
                        </div>

                        <br/>

                        @foreach ($grid->columns() as $column)
                            @if ($column->name())
                                <div class="checkbox">
                                    <label><input type="checkbox" class="pdf-column" value="1" name="{{$column->name()}}">{{$column->label()}}</label>
                                </div>
                            @endif
                        @endforeach

                        <br/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="padding-left:200px;">
                        <button id="generate-report-pdf" class="btn btn-primary" type="submit">Generate PDF</button>
                        <button id="generate-report-csv" class="btn btn-default" type="submit">Generate CSV</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report-pdf').on('click', function() {
        $('#report_type').val('pdf');
    });
    $('#generate-report-csv').on('click', function() {
        $('#report_type').val('csv');
    });

    $('#generate-report-form').submit(function() {
        if (! $('#generate-report-form').valid()) {
            return false;
        }

        $('#random_id').val(Date.now());
        return true;
    });

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        $('.pdf-column').prop('checked', false);
        if($(this).is(":checked")) {
            $('.pdf-column').prop('checked', true)
        }
        $('#generate-report-form').valid();
    });

    $('.pdf-column').change(function() {
        $('#generate-report-form').valid();
    });

    $('#generate-report-form').validate({
        rules: {
            f1: {
                requiredSelect: true
            },
            f2: {
                requiredSelect: true
            },
            toggle_checkbox: {
                required: function(elem) {
                    return $("input.pdf-column:checked").length == 0;
                }
            }
        },
        messages: {
            toggle_checkbox: {
                required: "Please select at least 1 checkbox."
            }
        }
    });

</script>
@endsection

@section('styles')
<style type="text/css">
    .form-horizontal .dynamic-filter-label {
        padding-top: 0px;
    }
</style>
@endsection
