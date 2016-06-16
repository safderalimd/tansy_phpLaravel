@extends('layout.cabinet')

@section('title', 'Client Visit')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
    	<div class="panel-heading">
        	<i class="glyphicon glyphicon-th-list"></i>
        	<h3>Client Visit</h3>
        	<a href="{!!url('/cabinet/client-visit/create/')!!}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Campaign <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Organization <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Status <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Visit Date <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->clientVisits() as $item)
                    <tr>
                        <td>{{$item['campaign_name']}}</td>
                        <td>{{$item['entity_name']}}</td>
                        <td>{{$item['client_status']}}</td>
                        <td>{{style_date($item['visit_date'])}}</td>
                      {{--   <td>
                            <a class="btn btn-default" href="{{url("/cabinet/client-visit/edit/{$item['visit_id']}")}}" title="Edit">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                            <a class="btn btn-default formConfirm" href="{{url("/cabinet/client-visit/delete/{$item['visit_id']}")}}"
                               title="Delete"
                               data-title="Delete Visit"
                               data-message="Are you sure to delete the selected record?"
                            >
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>

		    @include('commons.modal')

        </div>
    </div>
</div>

@endsection
