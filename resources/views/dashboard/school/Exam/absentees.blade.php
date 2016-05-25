@extends('layout.cabinet')

@section('title', 'Absentees')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Absentees</h3>
                </div>
                <div class="panel-body">

                    @include('commons.errors')

            <table class="table table-striped table-bordered table-hover" data-datatable>
                <thead>
                    <tr>
                        <th>Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exam->absentees() as $item)
                    <tr>
                        <td>{{$item[0]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

                    @include('commons.modal')

                </div>
            </div>
        </div>

@endsection
