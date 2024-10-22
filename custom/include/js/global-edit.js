jQuery( () => {
    if (! $("input[name='record']").val()) {
        let divisionField;
    
        if ($("#division").length) divisionField = $("#division");
        if ($("#division_c").length)  divisionField = $("#division_c");

        divisionField ? retrieveUserDivision(divisionField) : null;
    }

    customRelateFieldRemoveValue();
});

function retrieveUserDivision(field) {
    let parsedResponse;
    
    $.post('index.php?', {
        module: 'Users',
        action: 'retrieve_logged_user_division',
        to_pdf: true,
    }).done( (response) => {
        parsedResponse = JSON.parse(response);
        field.val(parsedResponse);
    });
}

// Custom Global Function for all relate fields in a form - Glai Obido
// Should trigger the clearRelateField when deleting the text on the relate field without clicking the clear button
// Fix implemented due to Ontrack #1090 
const customRelateFieldRemoveValue = () => {
    
    const relateFields = jQuery("div.edit-view-field[type=relate]");

    relateFields.each((index, el) => {
        // console.log(el)
        jQuery(el).children("input.sqsEnabled").on("keyup", function() {
            let fieldTextValue = jQuery(this).val();
            let fieldName = jQuery(this).attr('name');
            let fieldIdName = jQuery(this).siblings('input[type=hidden]').attr('name');
            
            if (fieldTextValue == '') {
                SUGAR.clearRelateField(this.form, fieldName, fieldIdName);
            }
        });

        
    })
}
