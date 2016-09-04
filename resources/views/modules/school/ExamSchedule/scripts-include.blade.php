<script type="text/javascript">

    // create datatale with checkbox column unsortable
    $('#exam-schedule-table').DataTable( {
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0 ] }
        ],
        "autoWidth": false
    });

    // check/uncheck all checkboxes
    $('#toggle-subjects').change(function() {
        $('.subject-entity-id').prop('checked', false);
        if($(this).is(":checked")) {
            var table = $('.table').DataTable();
            var rows = table.rows({ page: 'current' }).nodes();
            rows.each(function() {
                $('.subject-entity-id', this).prop('checked',true)
            });
        }
    });

    // reset all checkboxes after you change the page
    $('#exam-schedule-table').on('page.dt', function () {
        $('.subject-entity-id').prop('checked', false);
        $('#toggle-subjects').prop('checked', false);
    });

    // reload the page when selecting an exam
    $('#exam_entity_id').change(function() {
        if (this.value == 'none') {
            window.location.href = "/cabinet/exam-schedule";
        } else {
            window.location.href = "/cabinet/exam-schedule?f1=" + this.value;
        }
    });

    $('#schedule-rows-form').submit(function() {
        if (! $('#schedule-rows-form').valid()) {
            return false;
        }

        var exam_entity_id = $('#exam_entity_id').val();
        $('#hidden_exam_entity_id').val(exam_entity_id);

        // set the subjec ids
        var subjectIds = $('.subject-entity-id:checked').map(function() {
            // return this.value;
            return $(this).attr('data-classEntityId') + "-" + $(this).attr('data-subjectEntityId');
        }).get();

        if (subjectIds.length == 0) {
            alert("No subjects are selected.");
            return false;
        }

        $('#hidden_class_subject_ids').val(subjectIds.join(','));

        return true;
    });

    $('#schedule-rows-form').validate({
        rules: {
            exam_date: {
                required: true,
                dateISO: true
            },
            max_marks: {
                required: true,
                number: true,
                min: 0
            },
            exam_start_time: {
                required: true
            },
            exam_end_time: {
                required: true
            },
            average_reduced_marks: {
                required: true
            },
            grade_system_id: {
                requiredSelect: true
            }
        }
    });

    $('#exam_date').change(function() {
        $('#exam_date').valid();
    });

</script>
