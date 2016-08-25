@extends('layout.cabinet')

@section('title', 'Inbox')
@section('screen-name', 'mobile-grid-screen')

@section('content')

<div id="mobile-panel" class="panel-group">
    <section class="panel">

        <header class="panel-heading">
            <h3 class="panel-header-text">Inbox</h3>
            @if ($inbox->userCanSendMessage())
                <div class="new-message">
                    <a href="{{url("/cabinet/inbox/new")}}" class="btn btn-danger"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </div>
            @endif
        </header>

        <div class="panel-body">

            <div class="divider-line"></div>

            @if ($inbox->showSearch())
            <form action="/cabinet/inbox" class="form-inline" method="GET">
                <div class="search-box">
                    <button class="search-submit" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    <input type="text" name="q" value="{!!$inbox->searchQuery()!!}" class="search-input form-control" placeholder="Search">
                </div>
            </form>
            @endif

            <div class="inbox-list">

                @include('modules.communication.Inbox.messages')

            </div>
        </div>
    </section>
</div>

@endsection

@section('end-content')
    <div id="inbox-options">
        <div class="selected-message-count pull-left">0</div>
        <form id="delete-messages-form" method="POST" action="/cabinet/inbox/delete">
            <input type="hidden" name="email_id" id="deleted_messages">
            <button class="btn btn-default pull-left" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </form>
        <button class="btn btn-default pull-right close-options" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">

    $('.inbox-list').jscroll({
        loadingHtml: '<div class="preloader-scroll"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span></div>'
    });

    $('#delete-messages-form').submit(function() {

        var emailIds = $('.inbox-row.selected').map(function() {
            return $(this).attr('data-emailId');
        }).get();

        if (emailIds.length == 0) {
            alert("No rows are selected.");
            return false;
        }

        $('#deleted_messages').val(emailIds.join('|'));

        return true;
    });

    function unselectAllMessages() {
        $('.select-circle span').each(function() {
            var icon = $('.fa', $(this));
            icon.removeClass('fa-circle').addClass('fa-circle-thin');
            icon.closest('.inbox-row').removeClass('selected');
        })
        $('.selected-message-count').text(0);
    }

    $('.close-options').on('click', function() {
        $('#inbox-options').hide();
        unselectAllMessages();
    });

    $('.select-circle span').on('click', function() {
        var icon = $('.fa', $(this));

        if (icon.hasClass('fa-circle')) {
            icon.removeClass('fa-circle').addClass('fa-circle-thin');
            icon.closest('.inbox-row').removeClass('selected');
        } else {
            icon.removeClass('fa-circle-thin').addClass('fa-circle');
            icon.closest('.inbox-row').addClass('selected');
            $('#inbox-options').show();
        }

        if ($('.fa-circle').length == 0) {
            $('#inbox-options').hide();
        }

        $('.selected-message-count').text($('.fa-circle').length);
    });

    function openDetail(element, event)
    {
        if ($(element).hasClass('select-circle')) {
            event.stopPropagation();
            return;
        }

        var id = $(element).attr('data-emailId');
        window.location.href = "/cabinet/inbox/detail?id="+id;
    }

</script>
@endsection
