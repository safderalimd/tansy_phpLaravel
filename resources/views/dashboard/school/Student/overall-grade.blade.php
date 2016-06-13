@extends('layout.cabinet')

@section('title', 'Overall Grade')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Overall Grade</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Exam <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                        <th>Grade <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->overallDetails() as $item)
                    <tr>
                        <td>{{$item['exam']}}</td>
                        <td>{{$item['grade']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
