<script type="text/javascript">

    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.payment-row-id').prop('checked', true);
        } else {
            $('.payment-row-id').prop('checked', false);
        }
    });

    $('.payment-row-id').change(function() {
        updateTotalAmount();
    });

    // calculate total amounts based on payment types
    function updateTotalAmount() {

        $('.payment-type').each(function() {
            var paymentType = $(this).attr('data-paymentType');

            var totalAmount = 0;
            $('.payment-row-id:checked').each(function () {
                if ($(this).attr('data-paymentType') == paymentType) {
                    totalAmount += parseFloat($(this).attr('data-balanceAmount'));
                }
            });

            $(this).html("&#x20b9; " + addCommas(totalAmount));
        });
    }

    // format numbers
    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '.00';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $('#close-cash-counter-form').submit(function() {

        var collectionIds = $('.payment-row-id:checked').map(function() {
            return $(this).attr('data-dateid') + '$<>$' + $(this).attr('data-paymentTypeId') + '$<>$' + this.value;
        }).get();

        if (collectionIds.length == 0) {
            alert("No rows are selected.");
            return false;
        }

        $('#collection_ids').val(collectionIds.join('|'));

        return true;
    });

</script>
