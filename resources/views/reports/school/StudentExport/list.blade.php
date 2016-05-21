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

                  <form class="form-horizontal" action="{{ form_action() }}" id="generate-report-form" method="POST">
                      {{ csrf_field() }}

                      <input type="hidden" value="" name="row_type" id="row_type">

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
                                      <button class="btn btn-primary" type="submit">Generate Report</button>
                                  </div>
                            </div>
                        </div>
                      </div>
                  </form>



                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#generate-report-form').submit(function() {

        var rowType = $('#primary_key_id option:selected').attr('data-rowType');
        $('#row_type').val(rowType);

        return true;
    });

</script>
@endsection
