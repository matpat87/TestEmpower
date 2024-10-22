$(document).ready(function(){
    SaveForm();
    handleCustomMandatoryFields(); // on status change event
});

function handleCustomMandatoryFields() {
    $("select#status").on('change', function() {
        var statusValue = $(this).val(),
            statusFilters = ['Closed'],
            customRequiredFields = [
                { name: 'legally_reportable_c', type: 'enum', label:'Legally Reportable' },
                { name: 'root_cause_c', type: 'enum', label:'Root Cause' },
            ];
            

        // if selected statusValue is in the statusFilters array, make fields (type, department, due_date, severity, category) mandatory
        if (statusFilters.includes(statusValue)) {
            $.each(customRequiredFields, function(index, field) {
                addToValidate('EditView', field.name, field.type, true, field.label);

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel).append('<span class="required">*</span>');
                // console.log($('#due_date_c').val())
                // if (field.name == 'due_date_c' && $('#due_date_c').val() != null) {
                //     setDefaultDueDate();
                // }
            });
        } else {
            $.each(customRequiredFields, function(index, field) {
                removeFromValidate('EditView', field.name);

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel);

                $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
            });
        }

    }).trigger('change');
}

function TriggerTabChecking() {
    $('.tab-pane-NOBOOTSTRAPTOGGLER').each(function(index, item){
        var tab_pane = $(item);

        var validationMessagesObj= tab_pane.find('.validation-message');

        var tab_pane_id = tab_pane.attr('id');
        var tab_pane_index = tab_pane_id.substring(12); //count from tab pane id: tab-content-
        var nav_tab = $('#EditView_tabs .nav-tabs > li').eq(tab_pane_index);

        if(validationMessagesObj != null && validationMessagesObj.length > 0)
        {
            nav_tab.find('a').addClass('text-red-important');
        }
        else
        {
            nav_tab.find('a').removeClass('text-red-important');
        }
    });
}

function SaveForm()
{
    $('#SAVE.button.primary')
        .removeAttr('onclick')
        .on('click', (event) => {
            event.preventDefault();
            
            let _form = document.getElementById('EditView');
            _form.action.value = 'Save';
            check_form('EditView') && SUGAR.ajaxUI.submitForm(_form);

            // RemoveAllValidations();
            TriggerTabChecking();
        });
}