<br/><hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Comments</h3></div></div>

<div class="row">
    <div class="col-md-12">
        @if (count($issue->comments()))
            @foreach ($issue->comments() as $comment)
                <div class="row">
                    <div style="margin-bottom:10px;" class="col-md-12">
                        <div class="form-control">
                            {{$comment['comment']}}
                        </div>
                        <div class="pull-right">
                            <small>By: {{$comment['created_by']}} @ {{style_datetime($comment['created_date'])}}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            There are no comments.
        @endif
    </div>
</div>
<br/><br/>

<form class="form-horizontal" id="comment-form" action="{{ form_action().'/comment'.query_string() }}" method="POST">
    {{ csrf_field() }}

    <div class="row">
        <label class="col-md-2 control-label" for="comment">Comment</label>
        <div class="col-md-10">
            <textarea id="comment" name="comment" class="form-control" rows="6">{{old('comment')}}</textarea>
        </div>
    </div>
    <br/>

    <div class="row">
       <div class="col-md-12 text-center">
            <button class="pull-right btn btn-primary" type="submit">Add Comment</button>
            <a style="margin-right:10px;" href="{{ url("/cabinet/crm-issue").query_string()}}" class="pull-right btn btn-default cancle_btn">Cancel</a>
        </div>
    </div>
    <br/>

</form>

<br/><hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Tasks</h3></div></div>

<div class="row">
    <div class="col-md-12">
        @if (count($issue->tasks()))
            @foreach ($issue->tasks() as $task)
                <div class="row">
                    <div class="col-md-12">
                        <div style="margin-bottom:10px;" class="form-control">
                            <div class="pull-left">
                                {{$task['task_type']}} - {{$task['issue_status']}} - {{style_date($task['due_date'])}}
                            </div>
                            <div class="pull-right">Assigned To: {{$task['created_by']}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            There are no tasks.
        @endif
    </div>
</div>
<br/>

<div class="row">
   <div class="col-md-12">
        <a href="{{ url("/cabinet/crm-issue-task/create").'?id='.$issue->issue_id }}" class="pull-right btn btn-primary">Add Task</a>
    </div>
</div>
<br/>
