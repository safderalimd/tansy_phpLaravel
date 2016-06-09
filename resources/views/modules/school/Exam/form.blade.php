@extends('layout.cabinet')

@section('title', 'Exam')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Exam{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

               			<div class="form-group">
                            <label class="col-md-4 control-label" for="exam_name">Exam</label>
                            <div class="col-md-8">
                                <input id="exam_name" class="form-control" type="text" name="exam_name" value="{{ v('exam_name') }}" placeholder="Exam">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'   => 'Exam Type' ,
                            'name'    => 'exam_type_id',
                            'options' => $exam->examTypes(),
                            'keyId'   => 'exam_type_id',
                            'keyName' => 'exam_type',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="reporting_order">Reporting Order</label>
                            <div class="col-md-8">
                                <input id="reporting_order" class="form-control" type="text" name="reporting_order" value="{{ v('reporting_order') }}" placeholder="Reporting Order">
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/exam")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
