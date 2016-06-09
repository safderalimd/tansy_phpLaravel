@extends('layout.cabinet')

@section('title', 'Subject')

@section('content')
    <div class="row">
        <div class="col-md-8 sch_class panel-group panel-bdr">
            <div class="panel panel-primary">
			    <div class="panel-heading">
                	<i class="glyphicon glyphicon-th"></i>
                	<h3>Subject{{ form_label() }}</h3>
                </div>

                <div class="panel-body edit_form_wrapper">
                    <section class="form_panel">

                    @include('commons.errors')

                    <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                        {{ csrf_field() }}

               			<div class="form-group">
                            <label class="col-md-4 control-label" for="subject_name">Subject</label>
                            <div class="col-md-8">
                                <input id="subject_name" class="form-control" type="text" name="subject_name" value="{{ v('subject_name') }}" placeholder="Subject">
                            </div>
                        </div>

                        @include('commons.select', [
                            'label'   => 'Product Type' ,
                            'name'    => 'subject_type_id',
                            'options' => $subject->subjectTypes(),
                            'keyId'   => 'subject_type_id',
                            'keyName' => 'subject_type',
                        ])

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="reporting_order">Reporting Order</label>
                            <div class="col-md-8">
                                <input id="reporting_order" class="form-control" type="text" name="reporting_order" value="{{ v('reporting_order') }}" placeholder="Reporting Order">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="subject_short_code">Short Code</label>
                            <div class="col-md-8">
                                <input id="subject_short_code" class="form-control" type="text" name="subject_short_code" value="{{ v('subject_short_code') }}" placeholder="Short Code">
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/subject")}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
