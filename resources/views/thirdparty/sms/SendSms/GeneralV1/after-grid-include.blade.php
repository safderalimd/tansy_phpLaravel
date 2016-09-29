<div class="row">
    <div class="col-md-12">
        <form id="sms-textarea-form" class="form-horizontal" action="" method="POST">
            <textarea maxlength="275" name="sms_common_message" id="sms-message" class="form-control" rows="4"></textarea>
            <span class="pull-right text-muted"><span id="total-chars-used">275</span> left out of 275 characters</span>
        </form>
    </div>
</div>

<br/>

<nav class="nav-footer navbar navbar-default">
    <div class="container-fluid">
        <form class="navbar-form navbar-right" id="send-sms-form" action="{{form_action_full()}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="student_ids" id="student_ids" value="">
            <input type="hidden" name="common_message" id="common_message" value="">

            <a class="btn btn-default" href="/cabinet/send-sms-v1">Cancel</a>
            <button disabled="disabled" id="send-sms-button" type="submit" class="btn btn-primary">Send Sms</button>
        </form>
    </div>
</nav>
