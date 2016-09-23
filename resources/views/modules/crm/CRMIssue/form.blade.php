@extends('layout.cabinet')

@section('title', 'CRM Issue')

@section('content')
<div class="row">
    <div class="col-md-8 sch_class panel-group panel-bdr">
        <div class="panel panel-primary">
		    <div class="panel-heading">
            	<i class="glyphicon glyphicon-th"></i>
            	<h3>CRM Issue{!! form_label() !!}</h3>
            </div>

            <div class="panel-body edit_form_wrapper">
                <section class="form_panel">

                @include('commons.errors')

                <form class="form-horizontal" id="crm-issue-form" action="{{ form_action_full() }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-4 required control-label" for="title">Title</label>
                        <div class="col-md-8">
                            <input id="title" autocomplete="off" class="form-control" type="text" name="title" value="{{ v('title') }}" placeholder="Title">
                        </div>
                    </div>

                    @include('commons.select', [
                        'label'    => 'Project' ,
                        'name'     => 'project_entity_id',
                        'options'  => $issue->projects(),
                        'keyId'    => 'project_entity_id',
                        'keyName'  => 'project_name',
                        'none'     => 'Select a project..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'   => 'Issue Type' ,
                        'name'    => 'issue_type_id',
                        'options' => $issue->issueTypes(),
                        'keyId'   => 'issue_type_id',
                        'keyName' => 'issue_type',
                        'none'    => 'Select an issue type..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'   => 'Priority' ,
                        'name'    => 'issue_priority_id',
                        'options' => $issue->priorities(),
                        'keyId'   => 'issue_priority_id',
                        'keyName' => 'issue_priority',
                        'none'    => 'Select a priority..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'   => 'Issue Status' ,
                        'name'    => 'issue_status_id',
                        'options' => $issue->issueStatus(),
                        'keyId'   => 'issue_status_id',
                        'keyName' => 'issue_status',
                        'none'    => 'Select an issue status..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'   => 'Product' ,
                        'name'    => 'product_entity_id',
                        'options' => $issue->products(),
                        'keyId'   => 'product_entity_id',
                        'keyName' => 'product_name',
                        'none'    => 'Select a product..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'   => 'Product Release' ,
                        'name'    => 'product_release_id',
                        'options' => $issue->productRelease(),
                        'keyId'   => 'product_release_id',
                        'keyName' => 'product_release_name',
                        'none'    => 'Select a product release..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'   => 'Subject Account Type' ,
                        'name'    => 'subject_entity_id_filter',
                        'options' => $issue->accountType(),
                        'keyId'   => 'entity_type_id',
                        'keyName' => 'entity_type',
                        'none'    => 'Select an account type..',
                        'required' => true,
                    ])

                    @include('commons.select', [
                        'label'    => 'Subject Account' ,
                        'name'     => 'subject_entity_id',
                        'options'  => $issue->entityName(),
                        'keyId'    => 'entity_id',
                        'keyName'  => 'entity_name',
                        'data'     => 'entity_type_id',
                        'dataName' => 'entityId',
                        'none'     => 'Select an account..',
                        'required' => true,
                    ])

                    {{-- Created date - system date, always disable --}}
                    <div class="form-group">
                        <label class="col-md-4 control-label">Created Date</label>
                        <div class="col-md-8">
                            @if($issue->isNewRecord())
                                <div style="margin-bottom:0px;" class="well well-sm">{{ current_date() }}</div>
                            @else
                                <div style="margin-bottom:0px;" class="well well-sm">{{ style_date(v('issue_created_date')) }}</div>
                            @endif
                        </div>
                    </div>

                    @if($issue->isNewRecord())
                        <div class="form-group">
                            <label class="col-md-4 required control-label" for="owner_entity_id">Owner</label>
                            <div class="col-md-8">
                                <select autocomplete="off" id="owner_entity_id" class="form-control" name="owner_entity_id">
                                    <option value="none">Select an owner..</option>
                                    <?php $userId = Session::get('user.userID'); ?>
                                    @foreach($issue->user() as $option)
                                        <option @if($userId == $option['user_id']) selected @endif value="{{ $option['user_id'] }}">{{ $option['login_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        @include('commons.select', [
                            'label'   => 'Owner' ,
                            'name'    => 'owner_entity_id',
                            'options' => $issue->user(),
                            'keyId'   => 'user_id',
                            'keyName' => 'login_name',
                            'none'    => 'Select an owner..',
                            'required' => true,
                        ])
                    @endif

                    <div class="form-group">
                        <label class="col-md-4 required control-label" for="issue_due_date">Due Date</label>
                        <div class="col-md-8">
                            <div class="input-group date">
                                <input id="issue_due_date" class="form-control" type="text" name="issue_due_date" value="{{ v('issue_due_date') }}" placeholder="Due Date">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span
                                                class="glyphicon glyphicon-calendar"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-4 control-label" for="description">Description</label>
                        <div class="col-md-8">
                            <textarea id="description" name="description" class="form-control" rows="6">{{old('description')}}</textarea>
                        </div>
                    </div>

                    <br/>

                    @if($issue->isNewRecord())
                        <div class="row">
                           <div class="col-md-12 text-center grid_footer">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/crm-issue").query_string()}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                           <div class="col-md-6 col-md-offset-4 text-left">
                                <button class="btn btn-primary grid_btn" type="submit">Save</button>
                                <a href="{{ url("/cabinet/crm-issue").query_string()}}" class="btn btn-default cancle_btn">Cancel</a>
                            </div>
                        </div>
                    @endif
                </form>

                @if(!$issue->isNewRecord())
                    @include('modules.crm.CRMIssue.comments-and-tasks')
                @endif

                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

    $('#crm-issue-form').validate({
        rules: {
            title: {
                required: true
            },
            project_entity_id: {
                requiredSelect: true
            },
            issue_type_id: {
                requiredSelect: true
            },
            issue_priority_id: {
                requiredSelect: true
            },
            issue_status_id: {
                requiredSelect: true
            },
            product_entity_id: {
                requiredSelect: true
            },
            product_release_id: {
                requiredSelect: true
            },
            subject_entity_id_filter: {
                requiredSelect: true
            },
            subject_entity_id: {
                requiredSelect: true
            },
            owner_entity_id: {
                requiredSelect: true
            },
            issue_due_date: {
                required: true,
                dateISO: true
            }
        }
    });

    @if(!$issue->isNewRecord())
        $('#comment-form').validate({
            rules: {
                comment: {
                    required: true
                }
            }
        });
    @endif

    $(document).ready(function(){
        filterSelectbox({
            firstId: '#subject_entity_id_filter',
            firstFilter: 'value',
            secondId: '#subject_entity_id',
            secondFilter: 'data-entityId',
            initFirstSelect: true
        });
    });

</script>
@endsection
