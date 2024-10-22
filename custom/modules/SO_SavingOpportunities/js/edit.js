jQuery( function() {

    customSaveForm();

    $('#amount, #annual_spend').on('focus', function() {
        $(this).trigger('select');
    }).on('focusout', function() {
        customValidate($(this).attr('id'));
    });
    $("#sales_stage").on('change', SalesStageChanged).change();
    removeFromValidate('EditView', 'so_id');

    $('#previous_price_c, #current_price_c').on('focus', function() {
        $(this).trigger('select');
    }).on('focusout', function() {
        var label = $(this).attr("id") == 'previous_price_c'
            ? $("div[data-label='LBL_PREVIOUS_PRICE'").html().trim().replace(/:/g, '')
            : $("div[data-label='LBL_CURRENT_PRICE'").html().trim().replace(/:/g, '');
        
        // customValidateAvgSellPrice(label, $(this).attr("id")); // uncomment for ranger validation
    });

});

const customValidate = (field) => {
    let fieldToValidate = $(`#${field}`);
    let label = $(`div[field='${field}']`)
        .prev()
        .text()
        .trim()
        .replaceAll('*', '')
        .replaceAll(':', '');
    let value = $(fieldToValidate).val().replace("$", "");
    
    let requiredFields = ['amount'];

    if (! value || value === '' || value <= 0) {
        isRequired = requiredFields.includes(field) ? true : false;

        if (isRequired) {
            addToValidate('EditView', field, 'decimal', true, label );

            $(fieldToValidate)
                .parent()
                .find('.required.validation-message')
                .text(`Missing required field: ${label}`);
        } else {
            removeFromValidate('EditView', field);
        }
    } else {
        removeFromValidate('EditView', field);
        $(fieldToValidate)
            .removeAttr('style')
            .parent()
            .find('.required.validation-message')
            .remove();
    }
}

const customSaveForm = () => {
    let fieldsToValidate = ['amount', 'annual_spend','previous_price_c', 'current_price_c'];

    $.each(fieldsToValidate, function(index, field) {
        customValidate(field);
    });
    

    $('#SAVE.button.primary').on('click', () => {
        let _form = document.getElementById('EditView');
        _form.action.value = 'Save';

        $.each(fieldsToValidate, function(index, field) {
            customValidate(field);
        });

        if (check_form('EditView')) {
            SUGAR.ajaxUI.submitForm(_form); // this will submit the form
        }
    });
}

function SalesStageChanged(e) {
    var dropdown = $(e.currentTarget);
    var dropdownVal = dropdown.val();
    

    if(dropdownVal != '')
    {
        
        var postData = {'stage': dropdownVal, 'opportunity_id': $('input[name="id"]').val()};
        
        $.ajax({
            type: "POST",
            url: "index.php?module=SO_SavingOpportunities&action=get_status_dropdown&to_pdf=1",
            data: postData,
            async: false,
            dataType: 'json',
            success: function(result){
                if(result.success)
                {
                    $('#status_c option').remove();
    
                    $.each(result.data.options, function(index, item){
                        var option = new Option(item, index);
                        $('#status_c').append(option);
                    });

                    if(result.data.default_option != null && result.data.default_option != '')
                    {
                        $('#status_c').val(result.data.default_option);
                    }
                }
            },
            error: function(result){
                console.log(result);
            }
        });
    }
}

function InitializeSalesStage()
{
    
    var sales_stage_obj = $('#sales_stage');
    var current_sales_staege_value = sales_stage_obj.val();
    
    for(var i = 0; i < sales_stage_dom.length; i++)
    {
        var sales_stage_dom_val = sales_stage_dom[i];
        sales_stage_obj.append('<option value='+ sales_stage_dom_val[0] +'>'+ sales_stage_dom_val[1] +'</option>');
        
    }

    console.log(current_sales_staege_value);
    sales_stage_obj.val(current_sales_staege_value);
}

function customValidateAvgSellPrice(label, fieldname)
{
    min = 0;
    max = 9999.99;
    formname = 'EditView';

    addToValidate(formname, fieldname, 'currency', true, label);
    validate[formname][validate[formname].length-1][jstypeIndex] = 'range';
    validate[formname][validate[formname].length-1][minIndex] = min;
    validate[formname][validate[formname].length-1][maxIndex] = max;
}