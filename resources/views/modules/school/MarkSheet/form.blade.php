@extends('layout.cabinet')

@section('title', 'Mark Sheet Detail')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-th"></i>
                    <h3>Mark Sheet Detail</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" action="" method="POST">

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="product">Exam - </label>
                            <label class="col-md-4 control-label" for="product">Subject - </label>
                            <label class="col-md-4 control-label" for="product">Class - </label>
                        </div>
                        <hr/>

                        <div class="row">
                            <label class="col-md-5 control-label" for="product">Max Marks - </label>
                        </div>
                        <hr/>

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Roll Number <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                                    <th>Student Name <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                                    <th>Marks <i class="sorting-icon glyphicon glyphicon-chevron-down"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($markSheet->getMarkSheetRows() as $item)
                                    <tr class="">
                                        <td>{{$item['student_roll_number']}}</td>
                                        <td>{{$item['student_full_name']}}</td>
                                        <td>
                                            {{$item['student_marks']}}
                                            <div class="form-group">
                                                 <label class="col-md-4 control-label" for="product">Product Name</label>
                                                 <div class="col-md-8">
                                                     <input id="product" class="form-control" type="text" name="product_name" value="{{ v('product_name') }}" placeholder="Product Name">
                                                 </div>
                                             </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr/>
                        <div class="row">
                           <div class="col-md-7 text-left col-md-offset-5">
                                <button class="btn btn-primary grid_btn" type="button">Save</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
