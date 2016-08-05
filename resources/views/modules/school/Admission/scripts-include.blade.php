<script type="text/javascript">

    // Checkbox table header - toggle all checkboxes
    $('#toggle-subjects').change(function() {
        if($(this).is(":checked")) {
            $('.admission-id').prop('checked', true);
        } else {
            $('.admission-id').prop('checked', false);
        }
    });

    // Cancel Button - deselect all checkboxes
    $('#uncheck-all-checkboxes').on('click', function() {
        $('.admission-id').prop('checked', false);
        $('#toggle-subjects').prop('checked', false);
    });

    // Disable/Enable Move Button depending if checkboxes are selected
    $('.admission-id, #toggle-subjects').change(function() {
        if ($('.admission-id:checked').length > 0) {
            $('#move-admissions-submit').prop('disabled', false);
        } else {
            $('#move-admissions-submit').prop('disabled', true);
        }
    });

    // When submitting the form, prepend all selected checkboxes
    $('#move-students-form').submit(function() {
        var admissionIds = $('.admission-id:checked').map(function() {
            return this.value;
        }).get();

        if (admissionIds.length == 0) {
            alert("No admissions are selected.");
            return false;
        }

        $('#admission_ids').val(admissionIds.join(','));

        return true;
    });

    $('#move-students-form').validate({
        rules: {
            move_to_fiscal_year_entity_id: {
                requiredSelect: true
            },
            move_to_class_entity_id: {
                requiredSelect: true
            }
        }
    });
</script>
