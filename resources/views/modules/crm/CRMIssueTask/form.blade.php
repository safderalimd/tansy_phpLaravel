@extends('layout.cabinet')

@section('title', 'CRM Issue Task')

@section('content')
<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-th"></i>
                <h3>CRM Issue Task{!! form_label() !!}</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                <form class="form-horizontal" id="crm-issue-task-form" action="{{ form_action_full() }}" method="POST">
                    {{ csrf_field() }}

                    @include('commons.select', [
                        'label'    => 'Task Type' ,
                        'name'     => 'task_type_id',
                        'options'  => $issue->issueTaskTypes(),
                        'keyId'    => 'task_type_id',
                        'keyName'  => 'task_type',
                        'none'     => 'Select a task type..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'    => 'Product Component' ,
                        'name'     => 'product_component_id',
                        'options'  => $issue->productComponent(),
                        'keyId'    => 'product_component_id',
                        'keyName'  => 'component_name',
                        'none'     => 'Select a product component..',
                    ])

                    @include('commons.select', [
                        'label'    => 'Assigned To' ,
                        'name'     => 'assigned_individual_entity_id',
                        'options'  => $issue->user(),
                        'keyId'    => 'user_id',
                        'keyName'  => 'login_name',
                        'none'     => 'Select an assigned individual..',
                    ])

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="due_date">Due Date</label>
                        <div class="col-md-8">
                            <div class="input-group date">
                                <input id="due_date" class="form-control" type="text" name="due_date" value="{{ v('due_date') }}" placeholder="Due Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span
                                                class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    @include('commons.select', [
                        'label'    => 'Task Status' ,
                        'name'     => 'task_status_id',
                        'options'  => $issue->issueStatus(),
                        'keyId'    => 'issue_status_id',
                        'keyName'  => 'issue_status',
                        'none'     => 'Select a task status..',
                    ])

                    <div class="row grid_footer">
                       <div class="col-md-6 col-md-offset-4 text-left">
                            <button class="btn btn-primary grid_btn" type="submit">Save</button>
                            <a href="{{ url("/cabinet/crm-issue-task").query_string()}}" class="btn btn-default cancle_btn">Cancel</a>
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

    $('#crm-issue-task-form').validate({
        rules: {
            task_type_id: {
                requiredSelect: true
            }
        }
    });

</script>
@endsection
