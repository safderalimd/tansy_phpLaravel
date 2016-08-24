@extends('layout.cabinet')

@section('title', 'Events')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Events</h3>
        	<a href="{{url('/cabinet/events/create/').query_string()}}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <form class="form-horizontal" action="" method="POST">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="start_date">Start Date</label>
                    <div class="col-md-3 input-group date">
                        <input id="start_date" class="form-control" type="text" name="start_date" value="{{queryStringValue('st')}}" placeholder="Start Date">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2  control-label" for="end_date">End Date</label>
                    <div class="col-md-3 input-group date">
                        <input id="end_date" class="form-control" type="text" name="end_date" value="{{queryStringValue('en')}}" placeholder="End Date">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                        </span>
                    </div>
                </div>
            </form>


            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Event Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Event Type <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Start Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events->grid() as $item)
                    <tr>
                        <td>{{$item['event_name']}}</td>
                        <td>{{$item['event_type']}}</td>
                        <td>{{style_date($item['start_date'])}}</td>
                        <td>
                            <a class="btn btn-default" href="{{url("/cabinet/events/edit/{$item['event_id']}").query_string()}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/events/delete/{$item['event_id']}").query_string()}}"
                               title="Delete"
                               data-title="Delete Event"
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

    $('#start_date, #end_date').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get the query string
    function getQueryString() {
        var st = $('#start_date').val();
        var en = $('#end_date').val();

        var items = [];
        if (st) {
            items.push('st='+st);
        }
        if (en) {
            items.push('en='+en);
        }

        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }
</script>
@endsection
