@extends('layout.cabinet')

@section('title', 'Toppers')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Toppers</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Student Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Class Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exam->topperDetails() as $item)
                    <tr>
                        <td>{{$item['student_full_name']}}</td>
                        <td>{{$item['class_name']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
