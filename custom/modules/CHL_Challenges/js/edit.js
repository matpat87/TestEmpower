const customValidate = (field) => {
    let fieldToValidate = $(`#${field}`);
    let label = $(`div[field='${field}']`)
        .prev()
        .text()
        .trim()
        .replaceAll(':', '')
        .replaceAll('*', '');
    let value = $(fieldToValidate).val().replace("$", "");

    if (! value || value === '' || value <= 0) {
        console.log('if');
        addToValidate('EditView', field, 'decimal', true, label );
        $(fieldToValidate)
            .parent()
            .find('.required.validation-message')
            .text(`Missing required field: ${label}`);
    } else {
        console.log('else');
        removeFromValidate('EditView', field);
        $(fieldToValidate)
            .removeAttr('style')
            .parent()
            .find('.required.validation-message')
            .remove();
    }
}

$(document).ready(function(e){
    Initialize();
});

function Initialize(){
    console.log('Initialize');

    SaveForm();

    //customValidate('value_c');
    $('#value_c').on('change', ParseFloat);
}

function ParseFloat(e)
{
    console.log(e.currentTarget);
    var currentHTML = $(e.currentTarget);
    var amount = currentHTML.val().replace('$', '');
    amount = amount.replace(/,/g, '');
    //amount = parseFloat(amount);
    amount = parseFloat(amount.replace(/,/g, ''));
    var amount = isNaN(amount) ? 0 : amount;
    var value = '$' + parseFloat(amount).format(2);
    currentHTML.val(value);
}

function SaveForm()
{
    $('#SAVE.button.primary')
        .removeAttr('onclick')
        .on('click', (event) => {
            event.preventDefault();
            
            let _form = document.getElementById('EditView');
            _form.action.value = 'Save';

            if($('#value_c').val() != ''){
                customValidate('value_c');
            }

            if(check_form('EditView')){
                SUGAR.ajaxUI.submitForm(_form); // this will submit the form
            }
        });
}