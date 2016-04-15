@extends('layout.cabinet')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="{!!url('/cabinet/fiscalYear/create/')!!}" class="btn btn-block btn-primary" style="margin-bottom: 20px">Add new record</a>
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover" data-datatable>
        <thead>
            <tr>
                <th>Fiscal Year</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Current Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{$row['fiscal_year']}}</td>
                    <td>{{$row['start_date']}}</td>
                    <td>{{$row['end_date']}}</td>
                    <td>{{$row['current_fiscal_year']}}</td>
                    <td>
                        <a class="btn btn-default" href="{{url("/cabinet/fiscalYear/edit/{$row['fiscal_year_entity_id']}")}}" title="Edit">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
                        <a class="btn btn-default formConfirm" href="{{url("/cabinet/fiscalYear/delete/{$row['fiscal_year_entity_id']}")}}"
                           title="Delete"
                           data-title="Delete Fiscal Year"
                           data-message="Are you sure to delete the selected record?"
                        >
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="formConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="frm_title">Delete</h4>
                </div>
                <div class="modal-body" id="frm_body"></div>
                <div class="modal-footer">
                    <a style='margin-left:10px;' type="button" class="btn btn-primary col-sm-2 pull-right" id="frm_submit">Yes</a>
                    <button type="button" class="btn btn-danger col-sm-2 pull-right" data-dismiss="modal" id="frm_cancel">No</button>
                </div>
            </div>
        </div>
    </div>


@endsection
