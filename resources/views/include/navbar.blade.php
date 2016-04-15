<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navs-tab" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>
        <div id="navs-tab" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                @include(config('laravel-menu.views.bootstrap-items'), array('items' => $topbar->roots()))
            </ul>
        </div>
    </div>
</nav>