@extends('layout.cabinet')

@section('title', 'Move Student')

@section('content')

<div class="panel-group sch_class">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <h3>Move Student</h3>
        </div>
        <div class="panel-body">

            @include('commons.errors')

            <div class="row">
                <div class="col-md-4">
                    @include('commons.select', [
                        'label'   => 'Class' ,
                        'name'    => 'class_entity_id_filter',
                        'options' => $move->classes(),
                        'keyId'   => 'class_entity_id',
                        'keyName' => 'class_name',
                    ])
                </div>
            </div>

            <hr/>

           <table class="table table-striped table-bordered table-hover" data-datatable>
            <thead>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-md-1 col-md-offset-5">
                                <input type="checkbox" name=""></th>
                            </div>
                        </div>
                    <th>Student name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    <th>Roll Number <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                </tr>
            </thead>
            <tbody>
    @foreach($move->students() as $student)
    <tr>
        <td>
            <div class="row">
                <div class="col-md-1 col-md-offset-5">
                    <input type="checkbox" name="student_id" data-id="{{$student['student_entity_id']}}" data-class-id="{{$student['class_entity_id']}}" value="">
                </div>
            </div>
        </td>
        <td>{{$student['student_full_name']}}</td>
        <td>{{$student['student_roll_number']}}</td>
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
                    @foreach($move->fiscalYears() as $year)
                        <option value="{!!$year['fiscal_year_entity_id']!!}">{!!$year['fiscal_year']!!}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="move_to_class">Move to class</label>
            <div class="col-md-4">
                <select id="move_to_class" class="form-control" name="class_entity_id">
                    @foreach($move->classes() as $class)
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

<!--

Ajax request send: (or maybe just form)
    move_to_class_entity_id
    move_to_fiscal_year_entity_id
    class_student_ids

 -->

@endsection
