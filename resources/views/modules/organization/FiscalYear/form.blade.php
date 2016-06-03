@extends('layout.cabinet')

@section('title', 'Fiscal Year')

@section('content')

<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-th"></i>
                <h3>Fiscal Year{{ form_label() }}</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                <form class="form-horizontal" action="{{ form_action() }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">Fiscal Year</label>
                        <div class="col-md-6">
                            <input id="name" class="form-control" type="text" name="name" value="{{ v('name') }}" placeholder="Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="start_date">Start Date</label>
                        <div class="col-md-6">
                            <div class="input-group date">
                                <input id="start_date" class="form-control" type="text" name="start_date"
                                       value="{{ v('start_date') }}" placeholder="Start Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="end_date">End Date</label>
                        <div class="col-md-6">
                            <div class="input-group date">
                                <input id="end_date" class="form-control" type="text" name="end_date"
                                       value="{{ v('end_date') }}" placeholder="End Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="facility_ids">Facility</label>
                        <div class="col-md-8">
                            <select id="facility_ids" multiple class="form-control" name="facility_ids[]">
                                <?php
                                    $facilities = old('facility_ids');
                                    if (!is_array($facilities)) {
                                        $facilities = [];
                                    }
                                    if (is_array($fiscalYear->selectedFacilities)) {
                                        $facilities = $fiscalYear->selectedFacilities;
                                    }
                                ?>
                                @foreach($fiscalYear->facilities() as $option)
                                    <option @if(in_array($option['facility_entity_id'], $facilities)) selected @endif value="{{$option['facility_entity_id']}}">{{$option['facility_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-sm-5">
                            <div class="checkbox">
                                <label>
                                    <input {{ c('current_fiscal_year') }} type="checkbox" name="current_fiscal_year" value="1"> Current year?
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row_footer">
                       <div class="col-md-12 text-center grid_footer">
                            <button class="btn btn-primary grid_btn" type="submit">Save</button>
                            <a href="{{ url("/cabinet/fiscal-year")}}" class="btn btn-default cancle_btn">Cancel</a>
                        </div>
                    </div>
                </form>

                </section>
            </div>
        </div>
    </div>
</div>

@endsection
