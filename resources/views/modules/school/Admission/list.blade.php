@extends('layout.cabinet')

@section('title', 'Admission')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Student Admission</h3>
            <a href="{!!url('/cabinet/admission/create/')!!}" class="btn pull-right btn-default">Add new record</a>
        </div>
        <div class="panel-body">

            @include('commons.errors')

           <table class="table table-striped table-bordered table-hover" data-datatable>
            <thead>
                <tr>
                    <th><input type="checkbox" name="" value=""></th>
                    <th>Student Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Admission # <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Admission Date</th>
                    <th>Admitted</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    @foreach($students as $student)
    <tr>
        <td><input type="checkbox" name="" value=""></td>

        <td>{{$student['student_full_name']}}</td>
        <td>{{$student['admission_number']}}</td>
        <td>{{$student['admission_date']}}</td>
        <td>{{$student['admitted_to']}}</td>
        <td>{{$student['admission_status']}}</td>
        <td>
            <a class="btn btn-default" href="{{url("/cabinet/admission/edit/{$student['product_entity_id']}")}}" title="Edit">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            <a class="btn btn-default formConfirm" href="{{url("/cabinet/admission/delete/{$student['product_entity_id']}")}}"
               title="Delete"
               data-title="Delete Admission"
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

<div class="row">
<div class="col-md-12">
    <form class="form-horizontal">

        <div class="form-group">
            <label class="col-md-2 control-label" for="fiscal_years">Move to Fiscal Year</label>
            <div class="col-md-4">
                <select id="fiscal_years" class="form-control" name="fiscal_year_entity_id">
                    @foreach($admission->fiscalYears() as $year)
                        <option value="{!!$year['fiscal_year_entity_id']!!}">{!!$year['fiscal_year']!!}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="move_to_class">Move to class</label>
            <div class="col-md-4">
                <select id="move_to_class" class="form-control" name="class_entity_id">
                    @foreach($admission->classes() as $class)
                        <option value="{!!$class['class_entity_id']!!}">{!!$class['class_name']!!}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
           <div class="col-md-4 col-md-offset-2">
                <!-- uncheck all checkboxes -->
                <button type="button" class="btn btn-default">Cancel</button>

                <!-- disabled if no checkboses are set -->
                <!-- when clicked disable the button and show a preloader and say 'moving...' -->
                <button type="button" disabled="disabled" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    Move Selected Students
                </button>
            </div>
        </div>

    </form>
</div>
</div>

@endsection
