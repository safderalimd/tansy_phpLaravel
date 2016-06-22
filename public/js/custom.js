function filterSelect(options) {

    // hide all options except default option
    $(options.secondId + ' option').hide();
    $(options.secondId + ' option[value="none"]').show();

    $(options.firstId).change(function () {
        var selectedId = $(this).find('option:selected').attr(options.firstFilter);

        $(options.secondId + ' option').hide();
        $(options.secondId + ' option[value="none"]').show();

        if (selectedId == 'none') {
            return;
        }

        $(options.secondId + ' option').each(function() {
            if ($(this).attr(options.secondFilter) == selectedId) {
                $(this).show();
            }
        });
        $(options.secondId + ' option[value="none"]').prop('selected', true);
    });

}
