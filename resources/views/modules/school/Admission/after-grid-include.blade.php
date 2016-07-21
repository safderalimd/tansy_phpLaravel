<div class="row">
<div class="col-md-12">

    <form class="form-horizontal" id="move-students-form" action="{{url("/cabinet/admission/move-students/")}}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="admission_ids" id="admission_ids" value="">

        <div class="form-group">
            <label class="col-md-2 control-label" for="fiscal_years">Move to Fiscal Year</label>
            <div class="col-md-4">
                <select id="fiscal_years" class="form-control" name="move_to_fiscal_year_entity_id">
                    <option value="none">Select a fiscal year..</option>
                    @foreach($grid->fiscalYears() as $year)
                        <option value="{{$year['fiscal_year_entity_id']}}">{{$year['fiscal_year']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="move_to_class">Move to class</label>
            <div class="col-md-4">
                <select id="move_to_class" class="form-control" name="move_to_class_entity_id">
                    <option value="none">Select a class..</option>
                    @foreach($grid->classes() as $class)
                        <option value="{{$class['class_entity_id']}}">{{$class['class_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
           <div class="col-md-4 col-md-offset-2">
                <button type="button" id="uncheck-all-checkboxes" class="btn btn-default">Cancel</button>
                <button type="submit" id="move-admissions-submit" disabled="disabled" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    Move Selected Students
                </button>
            </div>
        </div>
    </form>

</div>
</div>
