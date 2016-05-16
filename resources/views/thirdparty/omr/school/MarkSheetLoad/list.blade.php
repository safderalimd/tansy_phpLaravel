@extends('layout.cabinet')

@section('title', 'Mark Sheet Load')

@section('content')

        <div class="panel-group sch_class">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <h3>Mark Sheet Load</h3>
                </div>
                <div class="panel-body">
                    @include('commons.errors')

                    <!--
                        Process:
                            select multiple files; display them in a grid
                            click 'import' button
                            upload files with ajax
                            process the files one by one (show status next to each file)
                            delete the files after you process them
                     -->


                    @include('commons.modal')
                </div>
            </div>
        </div>

@endsection
