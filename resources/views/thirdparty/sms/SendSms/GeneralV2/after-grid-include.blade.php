<nav class="nav-footer navbar navbar-default">
    <div class="container-fluid">
        <form class="navbar-form navbar-right" id="send-sms-form" action="{{form_action_full()}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="text_messages" id="text-messages" value="">

            <a class="btn btn-default" href="/cabinet/send-sms-v2">Cancel</a>
            <button disabled="disabled" id="send-sms-button" type="submit" class="btn btn-primary">Send Sms</button>
        </form>
    </div>
</nav>
