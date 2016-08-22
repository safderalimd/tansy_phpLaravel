<script type="text/javascript">

    function isOneTimeFrequency() {
        var frequency = $("#frequency_id option:selected").text();
        frequency = frequency.trim().split(' ').join('');
        frequency = frequency.toLowerCase();

        if (frequency == 'onetime') {
            return true;
        }

        return false;
    }
    $('#frequency_id').change(function() {
        if (isOneTimeFrequency()) {
            $('#end_date').prop('disabled', true);
            $('#end-date-btn button').prop('disabled', true);
            $('#end_date').val($('#start_date').val());
        } else {
            $('#end-date-btn button').prop('disabled', false);
            $('#end_date').prop('disabled', false);
        }
    });
    // if Frequency is OneTime, update end time when start time changes
    $('#start_date').change(function() {
        if ($('#end_date').is(':disabled')) {
            $('#end_date').val($('#start_date').val());
        }
    });

    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.payment-row-id').prop('checked', true);
        } else {
            $('.payment-row-id').prop('checked', false);
        }
    });

    $('#schedule-payment-v2-form').submit(function() {
        if (! $('#schedule-payment-v2-grid-form').valid()) {
            return false;
        }
        if (! $('#schedule-payment-v2-form').valid()) {
            return false;
        }

        var rowIds = $('.payment-row-id:checked').map(function() {
            amount = $(this).closest('tr').find('.input-amount-value').val();
            if (!amount) {
                amount = 'null';
            }
            return this.value + '$<>$' + amount;
        }).get();

        if (rowIds.length == 0) {
            alert("No rows are selected.");
            return false;
        }

        $('#row_ids').val(rowIds.join('|'));

        return true;
    });

    $('#schedule-payment-v2-form').validate({
        rules: {
            product_entity_id: {
                requiredSelect: true
            },
            frequency_id: {
                requiredSelect: true
            },
            start_date: {
                required: true,
                dateISO: true
            },
            end_date: {
                required: true,
                dateISO: true
            }
        }
    });

    $('#schedule-payment-v2-grid-form').validate();

    $('#start_date').change(function() {
        $('#start_date').valid();
    });

    $('#end_date').change(function() {
        $('#end_date').valid();
    });

</script>
