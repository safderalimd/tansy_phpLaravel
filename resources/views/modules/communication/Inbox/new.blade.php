@extends('layout.cabinet')

@section('title', 'Inbox')
@section('screen-name', 'mobile-grid-screen inbox-compose')

@section('content')

<div id="mobile-panel" class="panel-group">
    <section class="panel">

        <header class="panel-heading">
            <h3 class="panel-header-text">Inbox - Compose</h3>
        </header>

        <div class="panel-body">

            <form id="inbox-form" class="" action="{{ form_action() }}" method="POST">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12 compose-buttons">
                        <a href="{{url("/cabinet/inbox")}}" class="close-btn btn btn-default pull-left">Cancel</a>
                        <span class="compose-text">Compose</span>
                        <button class="btn btn-primary pull-right send-btn" type="submit">Send</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 to-field">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label class="btn">To:</label>
                            </span>

                            <div class="dropdown pull-right">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <ul class="dropdown-menu">
                                    <li data-contactId="1">John Doe</li>
                                    <li data-contactId="2">Jane Thompson</li>
                                    <li data-contactId="3">Ray Williams</li>
                                    <li data-contactId="4">Deby Oswald</li>
                                    <li data-contactId="5">Norman Philiphs</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 subject-field">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label class="btn">Subject:</label>
                            </span>
                            <input type="text" name="email_subject" class="subject-input form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 message-field">
                        <textarea rows="5" name="email_text" class="message-input form-control" placeholder=""></textarea>
                    </div>
                </div>

                <input type="hidden" name="send_to_entity_id_list" id="send_to_entity_id_list">
                <input type="hidden" name="cc_to_entity_id_list" id="cc_to_entity_id_list">
                <input type="hidden" name="bcc_to_entity_id_list" id="bcc_to_entity_id_list">

            </form>

        </div>
    </section>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    $('.dropdown-menu li').on('click', function() {
        var contactId = $(this).attr('data-contactId');

        var contactdAdded = false;
        $('.to-email').each(function() {
            if (contactId == $(this).attr('data-contactId')) {
                contactdAdded = true;
                return;
            }
        });
        if (contactdAdded) {
            return;
        }

        var name = $(this).text();
        var html;

        html =  '<span class="to-email" data-contactId="' + contactId + '">';
        html +=     '<span class="to-name">' + name + '</span>';
        html +=     '<span class="to-remove" onclick="removeTo(this)">';
        html +=         '<i class="fa fa-times" aria-hidden="true"></i>';
        html +=     '</span>';
        html += '</span>';

        $(html).insertAfter('.to-field .input-group-btn');
    });

    function removeTo(element) {
        $(element).closest('.to-email').remove();
    }

    $('#inbox-form').submit(function() {
        var toIds = $('.to-email').map(function() {
            return $(this).attr('data-contactId');
        }).get();

        if (toIds.length == 0) {
            alert("Select a contact person.");
            return false;
        }

        $('#send_to_entity_id_list').val(toIds.join(','));

        return true;
    });

</script>
@endsection
