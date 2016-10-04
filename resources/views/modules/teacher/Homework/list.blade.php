@extends('layout.cabinet')

@section('title', 'Homework')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Homework</h3>
            <a href="{!!url('/cabinet/homework/create/').query_string()!!}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">

                <div class="form-group">
                    <label class="col-md-1 control-label" for="start_date">Start Date</label>
                    <div class="col-md-2">
                        <div class="input-group date">
                            <input id="start_date" class="form-control" type="text" name="start_date" value="{{queryStringValue('sdt')}}" placeholder="Start Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>

                    <label class="col-md-1 control-label" for="end_date">End Date</label>
                    <div class="col-md-2">
                        <div class="input-group date">
                            <input id="end_date" class="form-control" type="text" name="end_date" value="{{queryStringValue('edt')}}" placeholder="End Date">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                            class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-1 control-label" for="class_entity_id">Class</label>
                    <div class="col-md-2">
                        <select id="class_entity_id" class="form-control" name="cei">
                            <option value="none">Select a class..</option>
                            @foreach($homework->classes() as $option)
                                <option {{ activeSelect($option['class_entity_id'], 'cei') }} value="{{ $option['class_entity_id'] }}">{{ $option['class_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </form>

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Subject <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Homework Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Due Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Homework <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homework->rows() as $item)
                    <tr>
                        <td>{{$item['subject_name']}}</td>
                        <td>{{style_date($item['home_work_date'])}}</td>
                        <td>{{style_date($item['due_date'])}}</td>
                        <td>{{$item['home_work']}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/homework/edit/{$item['home_work_id']}").query_string()}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/homework/delete/{$item['home_work_id']}").query_string()}}"
                               title="Delete"
                               data-title="Delete Homework"
                               data-message="Are you sure to delete the selected record?"
                            >
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @include('commons.modal')

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">

    $('#start_date, #end_date, #class_entity_id, #subject_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    function getQueryString() {
        var sdt = $('#start_date').val();
        var edt = $('#end_date').val();
        var cei = $('#class_entity_id option:selected').val();

        var items = [];
        if (sdt != "") {
            items.push('sdt='+encodeURIComponent(sdt));
        }
        if (edt != "") {
            items.push('edt='+encodeURIComponent(edt));
        }
        if (cei != "none") {
            items.push('cei='+cei);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

</script>
@endsection
