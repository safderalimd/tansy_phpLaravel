<nav class="nav-footer navbar navbar-default">
    <div class="container-fluid">
        <form class="navbar-form navbar-right" id="close-cash-counter-form" action="{{form_action_full()}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="collection_ids" id="collection_ids" value="">

            <button id="close-cash-counter" type="submit" class="btn btn-primary">Close Cash Counter</button>
        </form>
    </div>
</nav>
