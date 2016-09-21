<br/><hr/>
<div class="row"><div class="col-md-3 pull-left"><h3>Comments</h3></div></div>

<div class="row">
    <div class="col-md-12">
        ... comments
        Comments to be shown in labels, no input controls. Show comment date and comment created by towards right bottom. Eg: (By: Bill Clinton @ Dec 21st, 2016 13:42:00)
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
    <br/><br/>

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
        ... tasks
        Display multiple tasks as read only labels from result set#3, no need of input controls. It’s ok if you concatenate fields from one task into one line/label with some sort of separator. We need task type, task status, task due date and assigned to as part of one task.

    </div>
</div>
<br/><br/>

<div class="row">
   <div class="col-md-12">
        <a href="{{ url("/cabinet/crm-issue-task/create").query_string()}}" class="pull-right btn btn-primary">Add Task</a>
    </div>
</div>
<br/>
