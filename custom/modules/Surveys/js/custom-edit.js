const SaveForm = () => {
    $('#SAVE.button.primary')
    .removeAttr('onclick')
    .on('click', (event) => {
        event.preventDefault();
       
        let _form = document.getElementById('EditView');
        _form.action.value = 'Save';
        
        customQuestionFieldsValidation();

        let hasQuestionFields = questionsFieldCheck();

        if (check_form('EditView') && hasQuestionFields) {
            SUGAR.ajaxUI.submitForm(_form); // this will submit the form
        }
    });
}

const questionsFieldCheck = () => {
    // FALSE if no question exists
    let isValid = true;
    let questionBody = jQuery("#questionTable tbody.questionBody tr[data-question-index]:visible");
    let nonEditableResponseMsg = jQuery("#survey_questions_display_span").find('span.required.validation-message');

    // If "Survey questions with responses cannot be edited" message exists, let form submission proceed
    if (nonEditableResponseMsg.length > 0) {
        isValid = true;
        return isValid;
    }

    // No Questions Exist, force mandatory
    if (questionBody.length === 0) {
        isValid = false;
        jQuery("#survey_questions_display_span:not(.has-required-msg)").addClass('has-required-msg').prepend("<div class='required validation-message custom-msg'>Survey Question(s) are required.</div>");
        jQuery("div[field=survey_questions_display]").css('border', '1px solid red');
    }

    // Existing Record with Questions ENABLED
    if (questionBody.length > 0) {
        let hasEmptyQuestionVal = false;

        // Loop through questions and check if atleast one field is empty
        questionBody.find('.surveyQuestionName').each( (index, elem) => {
            let self = jQuery(elem);

            if (self.val().trim() === '') {
                hasEmptyQuestionVal = true;
                return false; // Exit the loop early if an empty value is found
            }
        });

        // If it contains an empty question value, force mandatory, else remove mandatory block on the entire questionnaire
        if (hasEmptyQuestionVal) {
            isValid = false;
            jQuery("#survey_questions_display_span:not(.has-required-msg)").addClass('has-required-msg').prepend("<div class='required validation-message custom-msg'>Survey Question(s) are required.</div>");
            jQuery("div[field=survey_questions_display]").css('border', '1px solid red');
        } else {
            isValid = true;
            jQuery("#survey_questions_display_span")
                .removeClass('has-required-msg')
                .find("div.required.validation-message.custom-msg")
                .remove();

            jQuery("div[field=survey_questions_display]").css('border', 'none');
        }
    }

    return isValid;
}

const customQuestionFieldsValidation = () => {

    if (jQuery("#questionTable tbody.questionBody tr").find('td > input.surveyQuestionName').length > 0) {
        jQuery("#questionTable tbody.questionBody tr:visible").find('td > input.surveyQuestionName').each(function(idx, el) {
            let fieldname = jQuery(el).attr('name');
            addToValidate('EditView', fieldname, 'text', true, 'Text');
        });
        
        jQuery("#questionTable tbody.questionBody tr:hidden").find('td > input.surveyQuestionName').each(function(idx, el) {
            let fieldname = jQuery(el).attr('name');
            removeFromValidate('EditView', fieldname);
        });
       
    }


};

jQuery( () => {
    removeFromValidate('EditView', 'survey_id_number_c');
    SaveForm(); // override save form event to add validation logic
});