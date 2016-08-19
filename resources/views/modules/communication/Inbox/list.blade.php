@extends('layout.cabinet')

@section('title', 'Inbox')
@section('screen-name', 'mobile-grid-screen')

@section('content')

<?php
    $messages = $inbox->messages();
    $totalMessages = $inbox->totalMessages();
?>

<div id="inbox-panel" class="panel-group">
    <section class="panel">

        <header class="panel-heading">
            <h3 class="panel-header-text">Inbox</h3>
            <div class="new-message">
                <button class="btn btn-danger" type="submit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            </div>
        </header>

        <div class="panel-body">

            <div class="divider-line"></div>
            <form action="/cabinet/inbox" class="form-inline" method="POST">
                <div class="search-box">
                    <button class="search-submit" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    <input type="text" class="search-input form-control" placeholder="Search">
                </div>
            </form>

            <div class="inbox-list">

                @include('modules.communication.Inbox.messages')

            </div>
        </div>
    </section>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

    $('.inbox-list').jscroll({
        loadingHtml: '<div class="preloader-scroll"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></div>'
    });

    // $('.inbox-list').jscroll({
    //     loadingHtml: '<img src="/images/page-loader.gif" alt="Loading" /> Loading...',
    //     padding: 20,
    //     nextSelector: 'a.jscroll-next:last',
    //     contentSelector: 'li'
    // });

    $('.select-circle span').on('click', function() {
        var icon = $('.fa', $(this));

        if (icon.hasClass('fa-circle')) {
            icon.removeClass('fa-circle').addClass('fa-circle-thin');
            icon.closest('tr').removeClass('selected');
        } else {
            icon.removeClass('fa-circle-thin').addClass('fa-circle');
            icon.closest('tr').addClass('selected');
        }
    });

</script>
@endsection
