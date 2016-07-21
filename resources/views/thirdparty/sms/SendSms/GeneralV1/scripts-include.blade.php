<script type="text/javascript">

    updateSendButton();

    @if ($grid->settings->showSearchBox())
        // create datatale with checkbox column unsortable
        $('#grid-table').DataTable( {
           "aoColumnDefs": [
               { 'bSortable': false, 'aTargets': [ 0 ] }
            ],
            "bPaginate": false,
            "autoWidth": false
        });
    @endif

    // max nr of charachters counter for text area
    $('#sms-message').keyup(function() {
        var textLength = $('#sms-message').val().length;
        var textRemaining = 160 - textLength;
        $('#total-chars-used').text(textRemaining);
    });

    // when the sms type dropdown changes redirect
    $('#sms_type_id').change(function() {
        updateQueryString();
    });

    // when the sms account type dropdown changes redirect
    $('#sms_account_entity_id').change(function() {
        updateQueryString();
    });

    function updateQueryString() {
        window.location.href = window.location.href.split('?')[0] + getQueryString();
    }

    // get teh query string depending on which selectboxes are set
    function getQueryString() {
        var sti = $('#sms_type_id option:selected').val();
        var aei = $('#sms_account_entity_id option:selected').val();
        var art = $('#sms_account_entity_id option:selected').attr('data-rowType');
        var eei = $('#exam_entity_id option:selected').val();

        var items = [];
        if (sti != "none") {
            items.push('sti='+sti);
        }
        if (aei != "none") {
            items.push('aei='+aei);
            items.push('art='+encodeURIComponent(art));
        }
        var queryString = items.join('&');
        if (queryString.length > 1) {
            return '?' + queryString;
        }
        return '';
    }

    function updateSendButton() {
        if (canSendSms()) {
            $('#send-sms-button').prop('disabled', false);
        } else {
            $('#send-sms-button').prop('disabled', true);
        }
    }

    function updateCurrentSelected() {
        var nr = $('.account-entity-id:checked').length;
        $('#current-selected').text(nr);
        updateSendButton();
    }

    function canSendSms() {
        var balance = $('#sms-balance-count').attr('data-balance');
        balance = parseInt(balance);
        var currentSelected = $('.account-entity-id:checked').length;
        if (balance == 0 || currentSelected > balance) {
            return false;
        }
        if (currentSelected <= 0) {
            return false;
        }
        return true;
    }

    // update current selected
    $('.account-entity-id').change(function() {
        updateCurrentSelected();
    });

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.account-entity-id').each(function() { if(this.value) {$(this).prop('checked', true);} });
        } else {
            $('.account-entity-id').prop('checked', false);
        }
        updateCurrentSelected();
    });

    $('#send-sms-form').submit(function() {
        if (! $('#sms-textarea-form').valid()) {
            return false;
        }

        var message = $('#sms-message').val();
        $('#common_message').val(message);

        var accountIds = $('.account-entity-id:checked').map(function() {
            return this.value;
        }).get();

        if (accountIds.length == 0) {
            alert("No accounts are selected.");
            return false;
        }

        $('#student_ids').val(accountIds.join(','));

        return true;
    });

    $('#sms-textarea-form').validate({
        rules: {
            sms_common_message: {
                required: true
            }
        }
    });

</script>
