jQuery( () => {
    // Make sure record is not distro generated before triggering custom editview functions as it may set uneditable fields to blank
    if ($("#distro_generated_c").val() == "0") {
        handlePopulateUOM();
        initializeDueDateCalendarFeatures();
        initializeDueDateCalendarFeatures('est_completion_date_c');
    }

    if ($("#due_date").val().length <= 0) {
        initializeDueDateCalendarFeatures();
        handlePopulateDueDate();
    }

    if ($("#est_completion_date_c").val().length <= 0) {
        initializeDueDateCalendarFeatures('est_completion_date_c');
        handlePopulateDueDate();
    }

    handleEstCompletionDateValidate();
    handleStatusFieldEditable();
    
});

const handlePopulateUOM = () => {
    $("#name").on('change', (e) => {
        let trId = $("#tri_techni0387equests_ida").val();
        let trItemName = e.target.value;
        let dropdown = $(e.currentTarget);
        let description = dropdown.find('option:selected').data('description');

        $("#uom").val(description);

        handlePopulateAssignedUser(trId, trItemName);
    }).trigger('change');
}

const initializeDueDateCalendarFeatures = (fieldName) => {
    fieldName = fieldName || 'due_date';
    let buttonName = fieldName ? fieldName + '_trigger' : 'due_date_trigger';

    Calendar.setup ({ 
        inputField : fieldName,
        form : 'EditView',
        ifFormat : '%m/%d/%Y %I:%M%P',
        daFormat : '%m/%d/%Y %I:%M%P',
        button : buttonName,
        singleClick : true,
        dateStr : '02/10/2019',
        startWeekday: 0,
        step : 1,
        weekNumbers:false
    });
}

const handlePopulateAssignedUser = (trId, trItemName) => {
    let recordId = $("input[name='record'][type='hidden']").val();

    $.ajax({
        type: "GET",
        url: "index.php?module=TRI_TechnicalRequestItems&action=get_assigned_user&to_pdf=1",
        data: {
            'record_id': recordId,
            'tr_id': trId,
            'tr_item_name': trItemName
        },
        dataType: 'json',
        success: function(response){
            $("#assigned_user_id").val(response.data.assigned_user_id);
            $("#assigned_user_name").val(response.data.assigned_user_name);
        }
    });
}

const handlePopulateDueDate = () => {
    let trId = $("#tri_techni0387equests_ida").val();
    
    $.ajax({
        type: "GET",
        url: "index.php?module=TRI_TechnicalRequestItems&action=get_due_date_and_est_completion_date&to_pdf=1",
        data: {
            'tr_id': trId,
        },
        dataType: 'json',
        success: function(response){
            (response.data.due_date) 
                ? $("#due_date").val(response.data.due_date) 
                : '';

            (response.data.est_completion_date_c) 
                ? $("#est_completion_date_c").val(response.data.est_completion_date_c) 
                : '';
        }
    });
}

const handleEstCompletionDateValidate = () => {
    
    jQuery('#status').on('change', function() {
        let currentStatus = jQuery(this).val();

        if (currentStatus == 'new' || currentStatus == '') {
            removeFromValidate('EditView', 'est_completion_date_c');
            let divField = $(`div[field='est_completion_date_c']`).prev();
            let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
            divField.text(divFieldNewLabel);
        } else {
            addToValidate('EditView', 'est_completion_date_c', 'date', true, 'Est Completion Date');
            let divField = $(`div[field='est_completion_date_c']`).prev();
            let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
            divField.text(divFieldNewLabel).append('<span class="required">*</span>');
        }
    }).trigger('change');


    YAHOO.util.Event.addListener('est_completion_date_c', 'change', () => {
        addToValidateCallback(
            'EditView', // Form Name
            'est_completion_date_c', // field name
            'date', // Field type
            true, // Is required
            "", // Message
            (formName, nameIndex) => { 
                let result = false;
                let newValue = jQuery('#est_completion_date_c').val();
                let dateVal = new Date(newValue);
                let dateNow = new Date();
                let reqCompletionDateVal = jQuery('#due_date').val();
                let reqCompletionDate = new Date(reqCompletionDateVal);
                dateNow.setHours(0, 0, 0, 0);
                
                if (dateVal < reqCompletionDate ) {
                    result = false;
                    $('#est_completion_date_c').removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
                    add_error_style(formName, nameIndex, "Invalid Date: Date should not be before Req Completion Date");
                    result = false;
                } else {
                    result = true;
                }
        
                return result;
        });
    });
}

const handleStatusFieldEditable = () => {
    let trStatus = $("#tr_status").val();
        
    if (['approved_awaiting_target_resin', 'more_information', 'awaiting_target_resin'].includes(trStatus) ) {
       jQuery('#status').addClass('custom-readonly')
    }
}

const handleTimePanelDisplay = () => {
    let fieldsToValidate = [
        { name: 'work_performed_non_db', type: 'name', label: 'Work Performed'}, 
        { name: 'date_worked_non_db', type: 'date', label: 'Date Worked'}, 
        { name: 'time_non_db', type: 'float', label: 'Time Spent', min: 1, max: 99.9}, 
    ];

    $("#status").on('change', (e) => {
        if (['complete', 'rejected'].includes(e.target.value)) {
            // show time subpanel and log time
            $('div[data-id=LBL_EDITVIEW_PANEL1]').parents('div.panel-default').css('display', 'block');
            
            $.each(fieldsToValidate, function(index, field) {
                addToValidate('EditView', field.name, field.type, true, field.label);
        
                if (field.min && field.max) {
                    validate['EditView'][validate['EditView'].length-1][jstypeIndex] = 'range';
                    validate['EditView'][validate['EditView'].length-1][minIndex] = field.min;
                    validate['EditView'][validate['EditView'].length-1][maxIndex] = field.max;
                }

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel).append('<span class="required">*</span>');
            });
        } else {
            // hide time subpanel
            $('div[data-id=LBL_EDITVIEW_PANEL1]').parents('div.panel-default').css('display', 'none');
            
            $.each(fieldsToValidate, function(index, field) {
                removeFromValidate('EditView', field.name);
                
                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel);
        
                $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
            });
        }
    }).trigger('change');
}