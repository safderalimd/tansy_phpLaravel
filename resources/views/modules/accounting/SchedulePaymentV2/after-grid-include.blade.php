<nav class="nav-footer navbar navbar-default">
    <div class="container-fluid">
        <form class="navbar-form navbar-right" id="schedule-payment-v2-form" action="{{form_action_full()}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="row_ids" id="row_ids" value="">

            <button id="schedule-btn" type="submit" class="btn btn-primary">Schedule</button>
            <a href="{{ url("/cabinet/schedule-payment-v2")}}" class="btn btn-default cancle_btn">Cancel</a>
        </form>
    </div>
</nav>
