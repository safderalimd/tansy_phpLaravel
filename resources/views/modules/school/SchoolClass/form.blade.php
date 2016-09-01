@extends('layout.cabinet')

@section('title', 'School Class')

@section('content')
<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-th"></i>
                <h3>School Class{{ form_label() }}</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                <form id="school-class-form" class="form-horizontal" action="{{ form_action() }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <div class="checkbox">
                                <label>
                                    @if($class->isNewRecord())
                                        <input checked="checked" name="active" type="checkbox" disabled readonly> Active
                                    @else
                                        <input {{ c('active') }} name="active" type="checkbox"> Active
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label required" for="class_name">Class Name</label>
                        <div class="col-md-8">
                            <input id="class_name" class="form-control" type="text" name="class_name" value="{{ v('class_name') }}" placeholder="Class Name">
                        </div>
                    </div>

                    @include('commons.select', [
                        'label'    => 'Class Group' ,
                        'name'     => 'class_group_entity_id',
                        'options'  => $class->classGroups(),
                        'keyId'    => 'class_group_entity_id',
                        'keyName'  => 'class_group',
                        'none'     => 'Select a class group..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'    => 'Class Category' ,
                        'name'     => 'class_category_entity_id',
                        'options'  => $class->classCategories(),
                        'keyId'    => 'class_category_entity_id',
                        'keyName'  => 'class_category',
                        'none'     => 'Select a class category..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'    => 'Teacher' ,
                        'name'     => 'class_teacher_entity_id',
                        'options'  => $class->employees(),
                        'keyId'    => 'employee_entity_id',
                        'keyName'  => 'employee_name',
                        'none'     => 'Select a teacher..',
                    ])

                    <div class="form-group">
                        <label class="col-md-4 control-label required" for="reporting_order">Reporting Order</label>
                        <div class="col-md-8">
                            <input id="reporting_order" class="form-control" type="text" name="reporting_order" value="{{ v('reporting_order') }}" placeholder="Reporting Order">
                        </div>
                    </div>

                    @include('commons.select', [
                        'label'    => 'Facility' ,
                        'name'     => 'facility_ids',
                        'options'  => $class->facilities(),
                        'keyId'    => 'facility_entity_id',
                        'keyName'  => 'facility_name',
                        'none'     => 'Select a facility..',
                        'required' => true,
                    ])

                    <div class="row_footer">
                       <div class="col-md-8 col-md-offset-4 text-center grid_footer">
                            <button class="btn btn-primary grid_btn" type="submit">Save</button>
                            <a href="{{ url("/cabinet/class")}}" class="btn btn-default cancle_btn">Cancel</a>
                        </div>
                    </div>
                </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">

    $('#school-class-form').validate({
        rules: {
            class_name: {
                required: true,
                maxlength: 100
            },
            class_group_entity_id: {
                requiredSelect: true
            },
            class_category_entity_id: {
                requiredSelect: true
            },
            reporting_order: {
                required: true,
                number: true,
                min: 0
            },
            facility_ids: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection

