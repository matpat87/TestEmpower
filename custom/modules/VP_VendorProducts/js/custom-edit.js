$(document).ready(function() {
    $("#SAVE.button.primary").removeAttr('accesskey');
    $("#SAVE.button.primary").removeAttr('onclick');
    $("#SAVE.button.primary").removeAttr('type');
    $("#SAVE.button.primary").attr('type', 'button');
    $('#SAVE.button.primary').click(function(event){
        var _form = document.getElementById('EditView');
        _form.action.value = 'Save';
        
        if (check_form('EditView')){ //&& SolutionDevelopmentClicked()){ //Commented as Requested by Steve for Prod Deployment on 7/1/2020
            
            SUGAR.ajaxUI.submitForm(_form); // this will submit the form
        }

        return false;
    });

    customCurrencyFieldValidate('LBL_PRODUCT_PRICE', 'product_price_c');
    customCurrencyFieldValidate('LBL_LAST_PURCHASE_PRICE', 'last_purchase_price');
    priceField();
});

function priceField()
{   

    $("#product_price_c, #last_purchase_price")
    .on('blur', function() {
        // calculateOpportunityAmount();
    })
    .on('focus', function() {
        $(this).select();
    })
}

function customCurrencyFieldValidate(dataLabel, fieldName)
{
    min = 0;
    max = 999.99;
    formname = 'EditView';
    label = $("div[data-label='" + dataLabel + "'").html().trim().replace(/:/g, '');
    addToValidate(formname, fieldName, 'currency', false, label);
    validate[formname][validate[formname].length-1][jstypeIndex] = 'range';
    validate[formname][validate[formname].length-1][minIndex] = min;
    validate[formname][validate[formname].length-1][maxIndex] = max;
}