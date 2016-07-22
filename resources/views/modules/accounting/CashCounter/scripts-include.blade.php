<script type="text/javascript">

    updateTotalAmount();

    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.cache-row-id').prop('checked', true);
        } else {
            $('.cache-row-id').prop('checked', false);
        }
        updateTotalAmount();
    });

    $('.cache-row-id').change(function() {
        updateTotalAmount();
    });

    function updateTotalAmount() {
        var totalAmount = 0;

        $('.cache-row-id:checked').each(function () {
            totalAmount += parseFloat($(this).attr('data-balanceAmount'));
        });

        $('#selected-total-amount').text(addCommas(totalAmount));
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

        var collectionIds = $('.cache-row-id:checked').map(function() {
            return $(this).attr('data-dateid') + '-' + this.value;
        }).get();

        if (collectionIds.length == 0) {
            alert("No rows are selected.");
            return false;
        }

        $('#collection_ids').val(collectionIds.join(','));

        return true;
    });

</script>
