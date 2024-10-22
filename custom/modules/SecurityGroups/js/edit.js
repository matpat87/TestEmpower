jQuery(() => {
    customSaveForm();
});

const customSaveForm = () => {
    jQuery('#SAVE.button.primary, #save_and_continue.button')
        .removeAttr('onclick')
        .on('click', async (event) => {
            await event.preventDefault();
            await handleCustomFormSubmit(event);
        });
}

const handleCustomFormSubmit = async (buttonEvent) => {
    if (await check_form('EditView')) {
        const duplicateCheckResponseData = await handleDuplicateCheck();

        if (duplicateCheckResponseData.isDuplicate) {
            return handleDuplicateRedirect(duplicateCheckResponseData.duplicateRecordId);
        }

        if (buttonEvent.target.id === 'save_and_continue') {
            // Retrieve Next Button Link to be used as parameter in Save and Continue button for the saveAndRedirect core function
            let nextButttonLink = jQuery("a[class='button btn-pagination'][title='Next']").attr('href').split("'")[0];

            // Don't remove, as this is necessary to force the form to be saved on sendAndRedirect
            let buttonElement = document.getElementById(buttonEvent.target.id);
            buttonElement.form.action.value = 'Save';

            // Instead of calling SUGAR.saveAndContinue (no action when called on custom on click), use sendAndRedirect instead
            sendAndRedirect('EditView', 'Saving Security Group...', nextButttonLink);
        } else {
            let _form = document.getElementById('EditView');
            _form.action.value = 'Save';

            SUGAR.ajaxUI.submitForm(_form);
        }
    }
}

const handleDuplicateCheck = async () => {
    const postData = {'record': jQuery("input[name='record'][type='hidden']").val()};
    const fieldsToCheck = ['name', 'type_c', 'site_c', 'division_c'];

    fieldsToCheck.forEach((field) => {
        postData[field] = jQuery(`#${field}`).val();
    });

    let responseData = {
        isDuplicate: false,
        duplicateRecordId: null
    };

    try {
        const response = await jQuery.post('index.php?', {
            module: 'SecurityGroups',
            action: 'check_if_duplicate_exists',
            to_pdf: true,
            postData: postData
        });

        const { data } = JSON.parse(response);
        responseData.isDuplicate = data.isDuplicate;
        responseData.duplicateRecordId = data.duplicateRecordId;
    } catch (error) {
        console.error("Error in handleDuplicateCheck: ", error);
        // Optionally, handle the error by setting responseData to a default state or performing other actions
    }

    return responseData;
}

const handleDuplicateRedirect = (duplicateRecordId) => {
    if (confirm("Data entered is flagged as duplicate! Would you like to redirect to the original record?")) {
        window.onbeforeunload = () => {}
        window.location.href = `/index.php?module=SecurityGroups&action=DetailView&record=${duplicateRecordId}`;
    }
}