$(document).ready(function(e){
    if(aos_product_id != '')
    {
        SetProdInfoUneditable();
    }

    if(!is_allow_process_for_rematch)
    {
        SetProdInfoUneditable();
    }

    if(status_c != ''){
        $('#status_c').attr('data-value', status_c);
    }

    SaveForm();

    $('#site_c')
        .on('change', SiteChanged)
        .trigger('change');

    let excludeFromTRPopulateArray= ['rematch_product', 'rematch_version', 'rematch_rejected', 'color_match'];
    let customRematchTypeVal = $("#custom_rematch_type").val();

    // If rematch_product or rematch_version, do not execute TR changed checker
    if (excludeFromTRPopulateArray.includes(customRematchTypeVal)) {
        // In view.edit.php, is_allow_process_for_rematch value is set to false if custom_rematch_type is rematch_version
        is_allow_process_for_rematch ? SetProdInfoEditable() : SetProdInfoUneditable();
    } else {
        SetTechnicalRequestChangedInterval();
    }
    
    $('#type').on('change', function(event){
        TypeChanged();
        //DisableFields();
    });
    TypeChanged(status_c);

    $('#status_c').on('change', function(event){
        DisableFields();
    }).change();

    
    $('.nav.nav-tabs a').not('.dropdown-toggle').on('click', function (event) {
        var the_id = event.target.id;

        if (the_id == 'tab0') {
            $('.panel-content').show();
        } else {
            $('.panel-content').hide();
        }
    });
});

//OnTrack #953 - Enable Product Information if comes from Cube
function EnableProductInformation(){
    //BI CUBE Integration User

}

function InitializeOEMAccount()
{
    sqs_objects['EditView_oem_account_c']['conditions'][1] = {
        name: "oem_c",
        op: "equals",
        value: 'Yes'
    };
    sqs_objects['EditView_oem_account_c']['conditions'][2] = {
        name: "status_c",
        op: "equals",
        value: 'Active'
    };
    sqs_objects['EditView_oem_account_c']['conditions'][3] = {
        name: "account_type",
        op: "equals",
        value: "OEMBrandOwner"
    };
    
    sqs_objects['EditView_oem_account_c']['group'] = 'and';

    SUGAR.util.doWhen(
        "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['EditView_oem_account_c']) != 'undefined'",
        enableQS
    );
}

function SaveForm()
{
    $('#SAVE.button.primary, #save_and_continue.button')
        .removeAttr('onclick')
        .on('click', (event) => {
            event.preventDefault();

            if (check_form('EditView')) {
                CheckTR($('#tr_technicalrequests_aos_products_2tr_technicalrequests_ida').val(), true).then( (data) => {
                    if (data) {
                        if (event.target.id == 'save_and_continue') {
                            // Retrieve Next Button Link to be used as parameter in Save and Continue button for the saveAndRedirect core function
                            let nextButttonLink = $("button[class='button btn-pagination'][title='Next']").attr('onclick').split("'")[1];

                            // Don't remove, as this is necessary to force the form to be saved on sendAndRedirect
                            let buttonElement = document.getElementById(event.target.id);
                            buttonElement.form.action.value = 'Save';
                            
                            // Instead of calling SUGAR.saveAndContinue (no action when called on custom on click), use sendAndRedirect instead
                            sendAndRedirect('EditView', 'Saving Product Master...', nextButttonLink);
                        } else {
                            var _form = document.getElementById('EditView');
                            _form.action.value = 'Save';

                            SUGAR.ajaxUI.submitForm(_form); // this will submit the form
                        }
                    }
                });
            }
        });
}

function DisableFields()
{
    var typeVal = $('#type').val();
    var statusVal = $('#status_c').val();

    // if ($('#id').val() != '') {
    //     $('#product_category_c')
    //         .attr("style", "pointer-events: none;")
    //         .addClass('custom-readonly');
    // }

    //Colormatch #170
    if (typeVal == 'development' && (! ['in_process', 'complete', 'rejected'].includes(statusVal))) {
        $('#resin_type_c, #geometry_c, #fda_eu_food_contract_c')
            .attr("style", "pointer-events: auto;")
            .removeClass('custom-readonly');
    } else {
        $('#resin_type_c, #geometry_c, #fda_eu_food_contract_c')
            .attr("style", "pointer-events: none;")
            .addClass('custom-readonly');
    }
}

function TypeChanged(defaultStatusValue = '')
{
    var type_dropdown = $('#type');
    var postData = { 'type' : type_dropdown.val() };
    var type_selected = type_dropdown.val();

    if(type_selected == 'development')
    {
        removeFromValidate('EditView','number_of_attempts_c');
        removeFromValidate('EditView','number_of_hours_c');
        $('div[data-label="LBL_NUMBER_OF_ATTEMPTS"]').html(lbl_number_of_attempts + ':');
        $('div[data-label="LBL_NUMBER_OF_HOURS"]').html(lbl_number_of_hours + ':');
    }
    else{
        addToValidate('EditView', 'number_of_attempts_c', 'varchar', true, lbl_number_of_attempts);
        addToValidate('EditView', 'number_of_hours_c', 'varchar', true, lbl_number_of_hours);
        $('div[data-label="LBL_NUMBER_OF_ATTEMPTS"]').html(lbl_number_of_attempts + ':<span class="required">*</span>');
        $('div[data-label="LBL_NUMBER_OF_HOURS"]').html(lbl_number_of_hours + ':<span class="required">*</span>');
    }

    $.ajax({
        type: 'POST',
        url: 'index.php?module=AOS_Products&action=get_status&to_pdf=1',
        data: postData,
        dataType: 'json',
        success: function (result) {
            if(result.success)
            {
                $('#status_c option').remove();

                $.each(result.data, function(index, item){
                    var option = new Option(item, index);

                    if(defaultStatusValue != null && defaultStatusValue.length && defaultStatusValue == index)
                    {
                        option.selected = true;
                    }

                    $('#status_c').append(option).trigger('change');
                });
            }
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        },
        complete: function(){ }
    });
}

function SiteChanged(e)
{
    var site_dropdown = $(e.currentTarget);

    $.ajax({
        type: 'POST',
        url: 'index.php?module=AOS_Products&action=get_site_list&to_pdf=1',
        data: {
            site: site_dropdown.val(),
        },
        success: function (data) {
            var result = JSON.parse(data);
            var result_options = '';

            if(result != null && result.success)
            {
                for(var i = 0; i < result.data.length; i++)
                {
                    result_options += '<option value="'+ result.data[i].id +'">'+ result.data[i].name +'</option>';
                }

                $('#user_id_c').find('option').remove().end().append(result_options);
            }
            else
            {
                $('#user_id_c').find('option').remove().end().append('<option value=""> </option>');
            }
        },
        error: function (errorThrown) {
            //alert('asd');
            console.log(errorThrown);
        },
        complete: function()
        {
            //alert('asd');
        }
    });
}

/**
 * This will trigger if TR is changed.
 * @author Steven Kyamko
 * @date 3/3/2020
 * **/
function SetTechnicalRequestChangedInterval(){
    var initial_tr_id = $('#tr_technicalrequests_aos_products_2tr_technicalrequests_ida').val();
    var return_module = $("input[type='hidden'][name='return_module']").val();

    setInterval(function(){ 
        var new_tr_id = $('#tr_technicalrequests_aos_products_2tr_technicalrequests_ida').val();
        //if (return_module === 'TR_TechnicalRequests') {
            if(is_allow_process || (initial_tr_id != new_tr_id) /*&& (aos_product_id == null || aos_product_id == '')*/) //aos_product_id is set in view.edit
            {
                is_allow_process = false;
                let createdByNameVal = $('span[id="created_by_name"]').html();
                let stageVal = $('#type').val();
    
                //OnTrack #953
                if(new_tr_id != '')
                {
                    CheckTR(new_tr_id, false).then(function(data){
                        if(createdByNameVal == 'BI CUBE Integration User' && stageVal == 'production'){
                            SetProdInfoEditable();
                            $('#resin_type_c').attr("style", "pointer-events: auto;");
                            $('#resin_type_c').removeClass('custom-readonly');
                        }
                    });
                }
                else
                {
                    ClearTRRelatedFields();

                    if(aos_product_id != ''){
                        PopulateProductMaster().then(function(result){
                            $('#base_resin_c').val(result.data.base_resin_c);
                            $('#color_c').val(result.data.color_c);
                            $('#geometry_c').val(result.data.geometry_c);
                            $('#fda_eu_food_contract_c').val(result.data.fda_eu_food_contract_c);
                            $('#resin_type_c').val(result.data.resin_type_c);
                            SetProdInfoUneditable();
                        });
                        
                    }
                    else{
                        ClearProdInfo();
                    }
                }

                if(is_allow_process_for_rematch)
                {
                    SetProdInfoEditable();
                }  

                initial_tr_id = new_tr_id;
            }
        //}
    }, 500);
    
}

function ClearTRRelatedFields()
{
    $('#application_c').val('');
    $('#market_c').val('');
    $('#mkt_markets_id1_c').val('');
}

function PopulateProductMaster(){
    var postData = {' product_id': $('#id').val() };

    return $.ajax({
        url: 'index.php?module=AOS_Products&action=get_aos_product&to_pdf=1',
        data: postData,
        dataType: 'json'
    });
}

function CheckTR(new_tr_id, isSubmit = false)
{
    var postData = {'technical_request_id': new_tr_id, 'product_id': $('#id').val(), 'type': $('#type').val()};
    var result = true;
    
    let excludeFromTRPopulateArray= ['rematch_product', 'rematch_version', 'rematch_rejected', 'color_match'];
    let customRematchTypeVal = $("#custom_rematch_type").val();

    return new Promise(function(resolve, reject) {
        if (excludeFromTRPopulateArray.includes(customRematchTypeVal)) {
            resolve(true); // Resolve promise and go to then()
        } else {
            $.ajax({
            url: 'index.php?module=AOS_Products&action=get_tr&to_pdf=1',
            data: postData,
            success: function(data) {

                var resultData = JSON.parse(data);

                if(resultData != null && resultData.success && resultData.data != null && resultData.data.id != null)
                {
                    $('#base_resin_c').val(resultData.data.resin_compound_type_c.key);
                    $('#color_c').val(resultData.data.color_c.key);
                    
                    if (! isSubmit) {
                        $('#geometry_c').val(resultData.data.cm_product_form_c.key);
                        $('#fda_eu_food_contract_c').val(resultData.data.fda_food_contact_c.key);
                    }

                    SetProdInfoUneditable();

                    if(resultData.data != null && resultData.data.technical_request != '')
                    {
                        $('#application_c').val(resultData.data.technical_request.application);
                    }

                    if(!resultData.products.is_allow_production)
                    {
                        alert('Only one active product is allowed in production');
                        result = false;
                    }

                    if(resultData.data != null && resultData.data.technical_request != null ){
                        //For Opportunities
                        if(resultData.data.technical_request.market_id != ''){ 
                            $('#market_c').val(resultData.data.technical_request.market_name);
                            $('#mkt_markets_id1_c').val(resultData.data.technical_request.market_id);
                        }

                        //Colormatch #294 - Due Date
                        if(resultData.data.technical_request.due_date_c != ''){
                            $('#due_date_c').val(resultData.data.technical_request.due_date_c);
                        }

                        if(resultData.data.technical_request.name != '') {
                            $('#name').val(resultData.data.technical_request.name);
                        }
                        
                        if(resultData.data.technical_request.site != '') {
                            $('#site_c').val(resultData.data.technical_request.site).trigger('change');
                        }

                        if (! isSubmit) {
                            //For Product Category
                            if(resultData.data.technical_request.product_category_c != ''){
                                $('#product_category_c').val(resultData.data.technical_request.product_category_c);
                            }
                        }
                    }
                }

                resolve(result); // Resolve promise and go to then()
            },
            error: function(err) {
                reject(err); // Reject the promise and go to catch()
            }
            });
        }
    });
}

function SetProdInfoUneditable()
{
    var rematch_type = $('#custom_rematch_type').val();

    $('#base_resin_c').attr("style", "pointer-events: none;");
    $('#base_resin_c').addClass('custom-readonly');
    $('#color_c').attr("style", "pointer-events: none;");
    $('#color_c').addClass('custom-readonly');
    // $('#geometry_c').attr("style", "pointer-events: none;");
    // $('#geometry_c').addClass('custom-readonly');
    // $('#fda_eu_food_contract_c').attr("style", "pointer-events: none;");
    // $('#fda_eu_food_contract_c').addClass('custom-readonly');
    $('#carrier_resin_c').attr("style", "pointer-events: none;");
    $('#carrier_resin_c').addClass('custom-readonly');

    if($('#custom_rematch_type').val() == 'rematch_product')
    {
        $('#product_category_c').attr("style", "pointer-events: none;");
        $('#product_category_c').addClass('custom-readonly');
    }
}

function SetProdInfoEditable()
{
    $('#base_resin_c').attr("style", "pointer-events: auto;");
    $('#base_resin_c').removeClass('custom-readonly');
    //$('#base_resin_c').val($('#base_resin_c option:first').val());

    $('#color_c').attr("style", "pointer-events: auto;");
    $('#color_c').removeClass('custom-readonly');
    //$('#color_c').val($('#color_c option:first').val());

    $('#geometry_c').attr("style", "pointer-events: auto;");
    $('#geometry_c').removeClass('custom-readonly');
    //$('#geometry_c').val($('#geometry_c option:first').val());

    $('#fda_eu_food_contract_c').attr("style", "pointer-events: auto;");
    $('#fda_eu_food_contract_c').removeClass('custom-readonly');
    //$('#fda_eu_food_contract_c').val($('#fda_eu_food_contract_c option:first').val());

    $('#carrier_resin_c').attr("style", "pointer-events: auto;");
    $('#carrier_resin_c').removeClass('custom-readonly');
    //$('#carrier_resin_c').val($('#carrier_resin_c option:first').val());

    $('#product_category_c').attr("style", "pointer-events: auto;");
    $('#product_category_c').removeClass('custom-readonly');
    //$('#product_category_c').val($('#carrier_resin_c option:first').val());
}

function ClearProdInfo()
{
    $('#base_resin_c').val($('#base_resin_c option:first').val());
    $('#color_c').val($('#color_c option:first').val());
    $('#geometry_c').val($('#geometry_c option:first').val());
    $('#fda_eu_food_contract_c').val($('#fda_eu_food_contract_c option:first').val());
    $('#carrier_resin_c').val($('#carrier_resin_c option:first').val());
    $('#name').val('');
    $('#site_c').val('').trigger('change');
    $('#user_id_c').val('').trigger('change');
}

/**
 * This will apply the Product Sequencer Logic
 * @author Steven Kyamko
 * @date 3/3/2020
 * **/
function ApplyProductSequencer(data)
{
    if(data != null)
    {
        var postData = {'base_resin': data.resin_compound_type_c.key,
                        'color': data.color_c.key,
                        'cm_product_form': data.cm_product_form_c.key,
                        'carrier_resin': data.resin_type_c.key,
                        'fda_eu_food_contract': data.fda_food_contact_c.key};

        let urlParameters = Object.entries(postData).map(e => e.join('=')).join('&');
        console.log(urlParameters);

        $.ajax({
            type: 'POST',
            url: 'index.php?module=AOS_Products&action=get_number_sequencer&to_pdf=1',
            data: postData,
            success: function (resultData) {
                var result = JSON.parse(resultData);

                if(result != null && result.success)
                {
                    $('#product_number_c').val(result.data.sequence);
                }
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            },
            complete: function(){ }
        });
    }
}