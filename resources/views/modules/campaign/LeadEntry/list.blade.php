@extends('layout.cabinet')

@section('title', 'Quick Lead Entry')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Quick Lead Entry</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <table id="lead-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($leads))
                        @foreach ($leads as $row)
                            <tr>
                                <td><input type="text" value="{{$row['first_name']}}" class="input_first_name form-control"></td>
                                <td><input type="text" value="{{$row['last_name']}}" class="input_last_name form-control"></td>
                                <td><input type="text" value="{{$row['mobile']}}" class="input_mobile form-control"></td>
                                <td><input type="text" value="{{$row['email']}}" class="input_email form-control"></td>
                            </tr>
                        @endforeach
                    @else
                        @for ($i=0;$i<10;$i++)
                            <tr>
                                <td><input type="text" class="input_first_name form-control"></td>
                                <td><input type="text" class="input_last_name form-control"></td>
                                <td><input type="text" class="input_mobile form-control"></td>
                                <td><input type="text" class="input_email form-control"></td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6 text-right">

                    <form class="form-horizontal" id="load-data-form" accept-charset="UTF-8" action="{{ url('/cabinet/lead---quick-entry/spreadsheet') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-3 control-label">Excel File</label>
                            <div class="col-md-9 text-left">
                                <label class="btn btn-default btn-file">
                                    Choose File...
                                    {!! Form::file('attachment', array('class'=>'form-control')) !!}
                                </label>
                                <span class="file-name"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-3 text-left">
                                <button class="btn btn-primary" type="submit">Load Data</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-md-6 text-right">
                    <button type="button" id="add-new-rows" class="btn btn-primary">Add 5 Rows</button>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-md-12 text-right">

                    <form class="form-horizontal" id="save-leads-form" accept-charset="UTF-8" action="{{ url('/cabinet/lead---quick-entry') }}" method="POST">
                        {{ csrf_field() }}

                        <input type="hidden" name="firstName_lastName_mobilePhone_email" id="firstName_lastName_mobilePhone_email">

                        <div class="form-group">
                            <label class="col-md-3 col-md-offset-6 control-label text-right">City</label>
                            <div class="col-md-3 text-right">
                                <select id="city_id" class="form-control" name="city_id">
                                    <option value="none">Select a city..</option>
                                    @foreach($lead->cities() as $city)
                                        <option value="{{$city['city_id']}}">{{$city['city_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-right">
                                <a href="{{ url("/cabinet/lead---quick-entry")}}" class="btn btn-default">Cancel</a>
                                <button class="btn btn-primary" type="submit">Save Leads</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

		    @include('commons.modal')

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('#load-data-form').validate({
        rules: {
            attachment: {
                required: true
            }
        }
    });

    $('#load-data-form').submit(function() {
        if (! $('#load-data-form').valid()) {
            return false;
        }

        return true;
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
            $('.file-name').text(label);
            $('#load-data-form').valid();
        });
    });

    $('#add-new-rows').on('click', function() {
        var row = '<tr>' +
            '<td><input type="text" class="input_first_name form-control"></td>' +
            '<td><input type="text" class="input_last_name form-control"></td>' +
            '<td><input type="text" class="input_mobile form-control"></td>' +
            '<td><input type="text" class="input_email form-control"></td>' +
        '</tr>';

        $('#lead-table tbody').append(row+row+row+row+row);
    });

    function getValue(field) {
        if (typeof field == 'string') {
            if (field.length == 0) {
                return 'null';
            } else {
                return field.replace('|','');
            }
        }

        return field;
    }

    $('#save-leads-form').submit(function() {
        if (! $('#save-leads-form').valid()) {
            return false;
        }

        var leadRows = $('#lead-table tbody tr').map(function() {
            var firstName = $(this).find('.input_first_name').val();
            var lastName = $(this).find('.input_last_name').val();
            var mobile = $(this).find('.input_mobile').val();
            var email = $(this).find('.input_email').val();

            return getValue(firstName) + '<$$>' + getValue(lastName) + '<$$>' + getValue(mobile) + '<$$>' + getValue(email);
        }).get();

        $('#firstName_lastName_mobilePhone_email').val(leadRows.join('|'));

        return true;
    });

    $('#save-leads-form').validate({
        rules: {
            city_id: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection
