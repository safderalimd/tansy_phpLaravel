<script type="text/javascript">

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
            return $(this).attr('data-dateid') + '$<>$' + $(this).attr('data-paymentTypeId') + '$<>$' + this.value;
        }).get();

        if (rowIds.length == 0) {
            alert("No rows are selected.");
            return false;
        }

        $('#collection_ids').val(rowIds.join('|'));

        return true;
    });

    $('#schedule-payment-v2-form').validate({
        rules: {
            product_entity_id: {
                requiredSelect: true
            },
            start_date: {
                required: true,
                dateISO: true
            }
        }
    });

    $('#schedule-payment-v2-grid-form').validate();

</script>
