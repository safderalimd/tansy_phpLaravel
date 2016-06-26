// filter selects for both update and insert
function filterSelectbox(options) {

    var isNewRecord = ('none' == $(options.secondId + ' option:selected').val());

    if (isNewRecord) {
        filterSelectNew(options);
    } else {
        filterSelectUpdate(options);
    }
}

// when forms are in insert mode
function filterSelectNew(options)
{
    // hide all options except default option
    $(options.secondId + ' option').hide();
    $(options.secondId + ' option[value="none"]').show();

    if (options.initAgain) {
        console.log('--init again--');
        applySelectFilterChange(options);
    }

    setSelectChangeBidings(options);
}

// when forms are in update mode
function filterSelectUpdate(options)
{
    var selectedId = $(options.secondId + ' option:selected').attr(options.secondFilter);

    $(options.secondId + ' option').each(function() {
        if ($(this).val() != 'none' && $(this).attr(options.secondFilter) != selectedId) {
            $(this).hide();
        }
    });

    if (options.initFirstSelect) {
        $(options.firstId + ' option').each(function() {
            if ($(this).attr(options.firstFilter) == selectedId) {
                $(this).prop('selected', true);
            }
        });
    }

    setSelectChangeBidings(options);
}

function setSelectChangeBidings(options)
{
    $(options.firstId).change(function() {
        applySelectFilterChange(options);
    });
}

function applySelectFilterChange(options)
{
    var selectedId = $(options.firstId).find('option:selected').attr(options.firstFilter);

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
}
