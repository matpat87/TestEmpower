var globalAllowReqCompDateCheck = false;

$(document).ready(function(e){
    Initialize();
});

function Initialize()
{
    SaveForm();
    MakeProbabilityEditable();
    handleEnableColorMatchAndRegulatoryTabFields(disableFieldsInTab);

    $('#related_technical_request_c').prop('readonly', 'true');
    $('#btn_related_technical_request_c').remove();
    $('#btn_clr_related_technical_request_c').remove();

    $('#distro_type_c').on('change', (e) => {
        DistroTypeChanged(e)
        handleCustomDistroTypeSubSelectValidation();
    }).trigger('change');

    $('#opp_trs').on('change', () => {
        handleCustomDistroTypeSubSelectValidation();
    }).trigger('change');

    $('#approval_stage').on('change', function(e) {
        StageChanged(e);
    }).trigger('change');

    $('#status').on('change', function(e){
        RemoveAllValidations();
        handleApproveDistroAndTRLabItemsCompleted();
        enableDisableSiteField();
        handleRematchTypeEnableDisable();
    }).trigger('change');

    $('#avg_sell_price_c, #annual_volume_c')
        .on('blur', CalculateAnnualAmount)
        .on('focus', function() {
            $(this).select();
        });
    
    $('#price_c').on('focus', function() {
        $(this).trigger('select');
    });
    
    $('#btn_distro_list').on('click', ShowDistroList);

    if ($("#type").val().length > 0) $("#type").addClass('custom-readonly');

    // $('#removeSDS').click(onRemoveSDS);

    removeFromValidate('EditView','annual_amount_c');
    removeFromValidate('EditView','annual_amount_weighted_c');
    removeFromValidate('EditView','price_c');
    SetAssignedToChangedInterval();
    onOpportunityChanged();
    onMatchInCustomersResinChanged();
    onCustomerProvidedChanged();
    onMatchTargetChanged();
    onReqCompletionDateChanged();
    onOpacityLevelChanged();
    handleOpportunityFieldEnableDisable();
    handleEstCompletionDateValidation();
    handleResinColorFieldsEnableDisable();
    onTypeChanged();
    handleAccountIdChanged();

    YAHOO.util.Event.onDOMReady(() => {
        let rematchType = jQuery("#custom_rematch_type").val();

        if (rematchType.length <= 0) {
            handleTypeFieldDropdownOptions(); // Need to trigger on initial load to filter dropdown options
        }
        
        YAHOO.util.Event.addListener('tr_technicalrequests_opportunitiesopportunities_ida', 'change', () => {
            handleTypeFieldDropdownOptions();
        });
    });
}

function onOpportunityChanged()
{
    var opportunity_id_prev = $('#tr_technicalrequests_opportunitiesopportunities_ida').val();
    var technical_request_id = $('#technical_request_id').val();
    
    setInterval(function(){ 
        var opportunity_id_new = $('#tr_technicalrequests_opportunitiesopportunities_ida').val();

        if(technical_request_id == '' && opportunity_id_prev != opportunity_id_new) //aos_product_id is set in view.edit
        {
            $.ajax({
                type: "POST",
                url: "index.php?module=TR_TechnicalRequests&action=get_technicalrequests_by_opportunity&to_pdf=1",
                data: {'opportunity_id': opportunity_id_new},
                dataType: 'json',
                success: function(result){
                    if(result.success)
                    {
                        var distro_type_options = $('#distro_type_c').data('options');

                        $('#distro_type_c option').remove();
                        $('#opp_trs option').remove();
                        if(result.data.tr_list != null && result.data.count > 0){
                            $('#opp_trs').attr('data-options', JSON.stringify(result.data.tr_list));

                            $.each(distro_type_options, function(index, item){
                                var option = new Option(item, index/*, isSelected, isSelected*/);
                                $('#distro_type_c').append(option);
                            });
                        }
                        else
                        {
                            $.each(distro_type_options, function(index, item){
                                if(index == "" || index == "new"){
                                    var option = new Option(item, index);
                                    $('#distro_type_c').append(option);
                                }
                            });
                        }

                        $('#opp_trs').change();

                        // $.each(result.data.tr_list, function(index, item){
                        //     //var isSelected = false;
                        //     var option = new Option(item, index/*, isSelected, isSelected*/);
                        //     $('#opp_trs').append(option);
                        // });

                        //$('#mdlDistributionList').modal('toggle');
                    }
                },
                error: function(result){
                    console.log(result);
                    alert('error');
                }
            });
            
            opportunity_id_prev = opportunity_id_new;
        }
    }, 500);
}

function onMatchInCustomersResinChanged() {
    
    let fieldsToValidate = [
        { name: 'mfg_c', type: 'varchar', label: 'Manufacturer'}, 
        { name: 'grade_id_number_c', type: 'varchar', label: 'Grade / ID #'}, 
        { name: 'customer_provided_c', type: 'enum', label: 'Customer Provided'}, 
    ];

    let approval_stage_val = $('#approval_stage').val();

    $("#match_in_customers_resin_c").on('change', function() {
        if ($(this).val() === 'yes') {
            $.each(fieldsToValidate, function(index, field) {
                if (approval_stage_val !== 'understanding_requirements') {
                    addToValidate('EditView', field.name, field.type, true, field.label);
                } else {
                    removeFromValidate('EditView', field.name);
                }

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel).append('<span class="required">*</span>');
            });
        } else {
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

function onCustomerProvidedChanged() {

    let fieldsToValidate = [
        { name: 'safety_data_sheet_new_c', type: 'Cstmfile', label: 'Safety Data Sheet'}, 
        { name: 'technical_data_sheet_c', type: 'Cstmfile', label: 'Technical Data Sheet'}, 
    ];

    let skipSdsValidation = false;
    let skipTdsValidation = false;
    let approval_stage_val = $('#approval_stage').val();

    $("#customer_provided_c").on('change', function() {
        if ($(this).val() === 'yes') {
            $.post('index.php?', {
                module: 'TR_TechnicalRequests',
                action: 'check_if_sds_document_exists',
                to_pdf: true,
                record_id: $("input[name=record]").val()
            }).done( (response) => {
                let parsedResponse = JSON.parse(response);
                skipSdsValidation = parsedResponse.data;

                $.each(fieldsToValidate, function(index, field) {
                    if (field.name === 'safety_data_sheet_new_c' && skipSdsValidation) {
                        return true;
                    }
                    
                    var fieldType = (field.name == 'safety_data_sheet_new_c' && $('#safety_data_sheet_new_c_old > a').length) ? 
                        'varchar' : 'file';
                    field.type = (field.name == 'safety_data_sheet_new_c') ? fieldType : field.type;

                    if (approval_stage_val !== 'understanding_requirements') {
                        addToValidate('EditView', field.name, field.type, true, field.label);
                    } else {
                        removeFromValidate('EditView', field.name);
                    }
    
                    let divField = $(`div[field='${field.name}']`).prev();
                    let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                    divField.text(divFieldNewLabel).append('<span class="required">*</span>');
                });
            });

            $.post('index.php?', {
                module: 'TR_TechnicalRequests',
                action: 'check_if_tds_document_exists',
                to_pdf: true,
                record_id: $("input[name=record]").val()
            }).done( (response) => {
                let parsedResponse = JSON.parse(response);
                skipTdsValidation = parsedResponse.data;

                $.each(fieldsToValidate, function(index, field) {
                    if (field.name === 'technical_data_sheet_c' && skipTdsValidation) {
                        return true;
                    }
                    
                    var fieldType = (field.name == 'technical_data_sheet_c' && $('#technical_data_sheet_c_old > a').length) ? 
                        'varchar' : 'file';
                    field.type = (field.name == 'technical_data_sheet_c') ? fieldType : field.type;

                    if (approval_stage_val !== 'understanding_requirements') {
                        addToValidate('EditView', field.name, field.type, true, field.label);
                    } else {
                        removeFromValidate('EditView', field.name);
                    }
    
                    let divField = $(`div[field='${field.name}']`).prev();
                    let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                    divField.text(divFieldNewLabel).append('<span class="required">*</span>');
                });
            });
        } else {
            $.each(fieldsToValidate, (index, field) => {
                removeFromValidate('EditView', field.name);

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel);

                $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
            });
        }
    }).trigger('change');
}

const onMatchTargetChanged = () => {

    let approval_stage_val = $('#approval_stage').val();

    let fieldsToValidate = [
        { name: 'competitor_c', type: 'relate', label: 'Competitor', relate_id: 'comp_competition_id_c'}, 
        { name: 'ci_competitor_c', type: 'enum', label: 'Competitor Concentrate LD'}, 
        { name: 'ci_product_form_c', type: 'enum', label: 'Geometry'}, 
    ];

    $("#industry_spec_c").on('change', (e) => {
        if (['competitor_chip', 'competitor_concentrate'].includes(e.target.value)) {
            $.each(fieldsToValidate, (index, field) => {
                if (approval_stage_val !== 'understanding_requirements') {
                    addToValidate('EditView', field.name, field.type, true, field.label);

                    if (field.type == 'relate') {
                        addToValidateBinaryDependency('EditView', field.name, 'alpha', true,`No match for field: ${field.label}`, field.relate_id );
                    }
                } else {
                    removeFromValidate('EditView', field.name);

                    if (field.type == 'relate') {
                        removeFromValidate('EditView', field.relate_id);
                    }
                }

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel).append('<span class="required">*</span>');
            });
        } else {
            $.each(fieldsToValidate, (index, field) => {
                removeFromValidate('EditView', field.name);

                if (field.type == 'relate') {
                    removeFromValidate('EditView', field.relate_id);
                }

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel);

                $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
            });
        }
    }).trigger('change');
}

function ShowDistroList(){
    var trId = $('#opp_trs').val();
    var postData = {'tr_id': trId};

    $.ajax({
        type: "POST",
        url: "index.php?module=TR_TechnicalRequests&action=get_distribution_list&to_pdf=1",
        data: postData,
        dataType: 'json',
        success: function(result){
            if(result.success)
            {
                var distribution_list_html = '';
                distribution_list_html += '<table class="table table-striped">';
                
                $.each(result.data.distribution_list, function(tr_index, tr){
                    var prevContactName;

                    if (tr_index === 0) {
                        distribution_list_html += '<tr style="background: #f9f9f9">';
                        distribution_list_html += '<td colspan="3" style="font-weight: bold;">'+ tr.header +'</td>';
                        distribution_list_html += '</tr>';                        
                    }

                    $.each(tr.data, function(distro_index, distro){

                        if (distro.contact_name != prevContactName) {
                            distribution_list_html += '<tr style="background: #fff">';
                            distribution_list_html += '<td style="padding-top: 25px;"><span style="font-weight: bold;">Contact Name </span>'+ distro.contact_name +'</td>';
                            distribution_list_html += '<td style="padding-top: 25px;"><span style="font-weight: bold;">Account Name </span>'+ distro.account_name +'</td>';
                            distribution_list_html += '<td style="padding-top: 25px;">&nbsp;</td>';
                            distribution_list_html += '</tr>';

                            distribution_list_html += '<tr style="background: #f9f9f9">';
                            tr.column_headers.forEach( (val, index) => {
                                distribution_list_html += `<td style="font-weight: bold;">${val}</td>`;
                            });
                            distribution_list_html += '</tr>';

                            prevContactName = distro.contact_name;
                        }

                        distribution_list_html += '<tr style="background: #fff">';
                        distribution_list_html += '<td>' + distro.distribution_item + '</td>';
                        distribution_list_html += '<td>' + distro.qty + '</td>';
                        distribution_list_html += '<td>' + distro.shipping_method + '</td>';
                        distribution_list_html += '</tr>';
                    });
                    
                });
                distribution_list_html += '</table>';

                $('#mdlDistributionList .modal-body').html(distribution_list_html);

                $('#mdlDistributionList').modal('toggle');
            }
        },
        error: function(result){
            console.log(result);
            alert('error');
        }
    });
}

function SetAssignedToChangedInterval(){
    var assigned_user_id = $('#assigned_user_id').val();
    
    setInterval(function(){ 
        var new_assigned_user_id = $('#assigned_user_id').val();

        if(assigned_user_id != new_assigned_user_id) //aos_product_id is set in view.edit
        {
            CheckAssignedTo(new_assigned_user_id);
            assigned_user_id = new_assigned_user_id;
        }
    }, 500);
}

function CheckAssignedTo(assigned_user_id = '')
{
    var stage = $('#approval_stage').val();
    if(stage == 'development' && assigned_user_id != ''){
        // $('#status').val('in_process');
    }
}

function MakeProbabilityEditable()
{
    var opportunityIDHdnObj = $('#tr_technicalrequests_opportunitiesopportunities_ida');
    var approvalStageObj = $('#approval_stage');
    var probabilityObj = $('#probability_c');
    var approvalStagePreviousVal = approvalStageObj.val();
    var prevOpportunityIDVal = opportunityIDHdnObj.val();

    setInterval(function(){
        var opportunityIDVal = opportunityIDHdnObj.val();
        var approvalStageVal = approvalStageObj.val();

        if(is_allow_opportunity_process || prevOpportunityIDVal != opportunityIDVal ||
            (approvalStagePreviousVal != approvalStageVal) )
        {
            is_allow_opportunity_process = false;
            prevOpportunityIDVal = opportunityIDVal;
            approvalStagePreviousVal = approvalStageVal;
            var postData = {'opportunity_id': opportunityIDVal, 
                'stage_id': approvalStageVal};

            $.ajax({
                type: "POST",
                url: "index.php?module=TR_TechnicalRequests&action=get_opportunity&to_pdf=1",
                data: postData,
                dataType: 'json',
                success: function(result){
                    if(result.success) {
                        probabilityObj.val(result.data.probability_percentage)
                        probabilityPreviousVal = result.probability_percentage;

                        if(result.data.opportunity.market_c != null && result.data.opportunity.market_c != '') {
                            $('#market_c').val(result.data.opportunity.market_c);
                            $('#mkt_markets_id_c').val(result.data.opportunity.mkt_markets_id_c);
                        } else {
                            $('#market_c').val('');
                            $('#mkt_markets_id_c').val('');
                        }

                        // On new TR, set Account and Contact value based on selected Opportunity
                        if ($("input[type=hidden][name='record']").val().length === 0) {
                            if (result.data.opportunity.tr_technicalrequests_accounts_name) {
                                $('#tr_technicalrequests_accounts_name').val(result.data.opportunity.tr_technicalrequests_accounts_name);
                                $('#tr_technicalrequests_accountsaccounts_ida').val(result.data.opportunity.tr_technicalrequests_accountsaccounts_ida);
                            } else {
                                $('#tr_technicalrequests_accounts_name').val('');
                                $('#tr_technicalrequests_accountsaccounts_ida').val('');
                            }

                            if (result.data.opportunity.contact_c) {
                                $('#contact_c').val(result.data.opportunity.contact_c);
                                $('#contact_id1_c').val(result.data.opportunity.contact_id1_c);
                            } else {
                                $('#contact_c').val('');
                                $('#contact_id1_c').val('');
                            }
                        }
                        
                    }
                },
                error: function(result){
                    console.log(result);
                    //alert('error');
                }
            });
        }


    }, 300);
}

function CalculateAnnualAmount(e)
{
    var avgSellPriceVal = $('#avg_sell_price_c').val().replace('$', '');
    avgSellPriceVal = avgSellPriceVal.replace(/,/g, '');
    avgSellPriceVal = parseFloat(avgSellPriceVal);
    var annualVolumeVal = parseFloat($('#annual_volume_c').val().replace(/,/g, ''));
    var amount = isNaN(avgSellPriceVal * annualVolumeVal) ? 0 : avgSellPriceVal * annualVolumeVal;
    var value = '$' + parseFloat(amount).format(2);
    $('#annual_amount_c').val(value);
    RemoveAllValidations();
}

function StageChanged(e)
{
    var selectHTMLObj = $(e.currentTarget);
    var recordId = $("input[name='record']").val();
    var stageVal = selectHTMLObj.val();
    var postData = { 'id': recordId, 'stage' : stageVal, 'is_submit_for_development': tr_is_submit_to_dev };
    var sales_stage = $('#approval_stage').val();
    
    $.ajax({
        type: "POST",
        url: "index.php?module=TR_TechnicalRequests&action=get_status_dropdown&to_pdf=1",
        data: postData,
        dataType: 'json',
        success: function(result){
            if(result.success)
            {
                $('#status option').remove();

                $.each(result.data, function(index, item){
                    var isSelected = (tr_sales_stage == sales_stage && index == tr_status);
                    var option = new Option(item, index, isSelected, isSelected);
                    $('#status').append(option);
                });

                $('#status').trigger('change');
                handleRematchTypeEnableDisable();
                CheckAssignedTo($('#assigned_user_id').val());
                enableDisableSiteField();
            }
        },
        complete: function(){
            RemoveAllValidations();

        },
        error: function(result){
            console.log(result);
            alert('error');
        }
    });
}

const RemoveAllValidations = () => {
    let stageVal = jQuery('#approval_stage').val();
    let { mandatoryFields, nonMandatoryFields } = retrieveFieldsToMap();

    mandatoryFields && mandatoryFields.length > 0 ? mandatoryFields.forEach( (field) => {
        addToValidate('EditView', field.name, field.type, true, field.label);
    }) : '';
    
    nonMandatoryFields && nonMandatoryFields.length > 0 ? nonMandatoryFields.forEach( (field) => {
        removeFromValidate('EditView', field.name);
    }): '';

    if (! ['understanding_requirements', 'closed_rejected'].includes(stageVal)) {
        onMatchInCustomersResinChanged();
        onCustomerProvidedChanged();
        onMatchTargetChanged();
        onOpacityLevelChanged();
        handleEstCompletionDateValidation();
        
        // On Type Changed should always be called last as it handles show/hide of tabs with add/remove validations
        onTypeChanged();

        // Custom validations should always be called last to not get overwritten by validators above
        customValidate('avg_sell_price_c');
        customValidateAnnualVolume();
        customDateFieldValidation('req_completion_date_c');
    }
}

function SaveForm()
{
    $('#SAVE.button.primary, #save_and_continue.button')
        .removeAttr('onclick')
        .on('click', (event) => {
            event.preventDefault();

            let buttonEvent = event;
            let stageVal = $("#approval_stage").val();
            let statusVal = $("#status").val();
            let typeVal = $("#type").val();
            let acceptedTypeList = ['color_match', 'rematch', 'cost_analysis', 'ld_optimization'];
            let recordId = $("input[name='record'][type='hidden']").val();

            if (recordId.length > 0 && acceptedTypeList.includes(typeVal) && stageVal === 'development') {
                if (statusVal === 'new') {
                    handleDevelopmentNewDistroExists(buttonEvent);
                } else if (statusVal === 'approved') {
                    handleDevApprovedCheckIfColorMatcherExists(buttonEvent);
                } else if (statusVal === 'development_complete') {
                    handleDevCompleteCheckIfProductMasterExists(buttonEvent);
                } else {
                    handleTabAndFieldsValidationWithSubmit(buttonEvent);
                }
            } else {
                handleTabAndFieldsValidationWithSubmit(buttonEvent);
            }

        });

    if (tr_is_submit_to_dev) {
        let buttonEvent = {
            target: { id: 'SAVE' }
        };

        setTimeout(() => {
            handleDevelopmentNewDistroExists(buttonEvent);
        }, 1000);
    }
}

function handleTabAndFieldsValidationWithSubmit(buttonEvent)
{
    handleCustomDistroTypeSubSelectValidation();
    RemoveAllValidations();
    
    check_form('EditView');
    handleTabMandatoryIndicator();

    if ($('.validation-message:not([style*="display: none"])').length < 1) {
        if (buttonEvent.target.id == 'save_and_continue') {
            // Retrieve Next Button Link to be used as parameter in Save and Continue button for the saveAndRedirect core function
            let nextButttonLink = $("button[class='button btn-pagination'][title='Next']").attr('onclick').split("'")[1];

            // Don't remove, as this is necessary to force the form to be saved on sendAndRedirect
            let buttonElement = document.getElementById(buttonEvent.target.id);
            buttonElement.form.action.value = 'Save';
            
            // Instead of calling SUGAR.saveAndContinue (no action when called on custom on click), use sendAndRedirect instead
            sendAndRedirect('EditView', 'Saving Technical Request...', nextButttonLink);
        } else {
            let _form = document.getElementById('EditView');
            _form.action.value = 'Save';
            
            SUGAR.ajaxUI.submitForm(_form);
        }
    }
}

function DistroTypeChanged(event)
{
    var dropdown = $(event.currentTarget);
    
    //should only happen in TR not edited
    if(dropdown.val().length > 0 && (dropdown.val() == 'copied' || dropdown.val() == 'linked')) //Fix issue in Distro Type - SK cannot change tabs
    {
        $('#opp_trs option').remove();
        var optionObj = $('#opp_trs').data('options');

        if (optionObj) {
            $.each(optionObj, function(index, item){
                var option = new Option(item, index);
                $('#opp_trs').append(option);
            });
        }
        
        $('#opp_trs').show();
        $('#btn_distro_list').show()
    }
    else
    {
        $('#opp_trs option').remove();
        $('#opp_trs').hide();
        $('#btn_distro_list').hide()
    }
}

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
        addToValidate('EditView', field, 'decimal', true, label );
        $(fieldToValidate)
            .parent()
            .find('.required.validation-message')
            .text(`Missing required field: ${label}`);
    } else {
        removeFromValidate('EditView', field);
        $(fieldToValidate)
            .removeAttr('style')
            .parent()
            .find('.required.validation-message')
            .remove();
    }
}

const customValidateAnnualVolume = () => {   
    let min = 0.01;
    let formname = 'EditView';
    let fieldname = 'annual_volume_c';
    let fieldToValidate = $(`#${fieldname}`);
    let label = $(`div[field='${fieldname}']`)
        .prev()
        .text()
        .trim()
        .replaceAll(':', '')
        .replaceAll('*', '');

    addToValidate(formname, fieldname, 'currency', true, label);
    validate[formname][validate[formname].length-1][jstypeIndex] = 'range';
    validate[formname][validate[formname].length-1][minIndex] = min;

    $(fieldToValidate)
        .parent()
        .find('.required.validation-message')
        .text(`Missing required field: ${label}`);
}

//Colormatch #272
// function onRemoveSDS(e)
// {
//     e.preventDefault();
//     $('#sdsDetailContainer').remove();
//     $('#sdsEditContainer').show();
// }

const handleCustomDistroTypeSubSelectValidation = () => {
    let distroType = $("#distro_type_c");
    let distroTypeSubSelect = $("#opp_trs");
    let distroTypeAcceptedOptions = ['copied'];

    let distroTypeLabel = $(`div[field='distro_type_c`)
        .prev()
        .text()
        .trim()
        .replaceAll('*', '')
        .replaceAll(':', '');

    if (checkValidate('EditView', 'opp_trs')) {
        removeFromValidate('EditView', 'opp_trs');
    }

    if (distroTypeAcceptedOptions.includes(distroType.val())) {
        addToValidate('EditView', 'opp_trs', 'enum', true, distroTypeLabel);
    } else {
        distroTypeSubSelect.attr('style', 'display: none');
    }
}

// Used to check condition if original Product # (Customer Products) related field has been hidden and vacant field space on the right has been removed
let isOnPageLoadHideFieldTriggered = false;

const onTypeChanged = () => {
    let type = $("#type");
    let colormatchTypeDiv = $("div[field='colormatch_type_c']");
    let colormatchType = $("#colormatch_type_c");
    let colormatchTypeLabel = colormatchTypeDiv
        .prev()
        .text()
        .trim()
        .replaceAll('*', '')
        .replaceAll(':', '');
    
    let approval_stage_val = $('#approval_stage').val();

    const colormatchTypeDefaultValue = colormatchType.val();
    let acceptedTypeList = ['color_match', 'rematch', 'cost_analysis', 'ld_optimization', 'raw_material_evaluation'];

    // Hide Product # (Customer Products) relate field and remove blank space beside field on page load as it shows on bottom of general tab
    if (! isOnPageLoadHideFieldTriggered) {
        if ($("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item:not(.hidden)').length > 0) {
            $("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item').addClass('hidden');
            isOnPageLoadHideFieldTriggered = true;
        }

        if ($("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item:not(.hidden)').length > 0) {
            $("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item').addClass('hidden');
            isOnPageLoadHideFieldTriggered = true;
        }
    }
    
    type.on('change', (e) => {
        if (! acceptedTypeList.includes(e.target.value)) {
            (checkValidate('EditView', 'colormatch_type_c')) ? removeFromValidate('EditView', 'colormatch_type_c') : null;

            colormatchType.val('');
            colormatchTypeDiv
                .parent()
                .hide();
            
            if (e.target.value !== 'product_sample') {
                // Show Product # (Customer Products) relate field and hide Product Name
                $("#ci_customeritems_tr_technicalrequests_1_name")
                    .closest('.edit-view-row-item.hidden')
                    .removeClass('hidden')
                    .insertBefore($("#name").closest('.edit-view-row-item'));
                $("#name").closest('.edit-view-row-item').addClass('hidden');

                $("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item').addClass('hidden');
            } else {
                // Show Product # (Product Master) relate field and hide Product Name
                $("#tr_technicalrequests_aos_products_2_name")
                    .closest('.edit-view-row-item.hidden')
                    .removeClass('hidden')
                    .insertBefore($("#name").closest('.edit-view-row-item'));
                $("#name").closest('.edit-view-row-item').addClass('hidden');

                $("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item').addClass('hidden');
            }
        } else {
            if (approval_stage_val !== 'understanding_requirements') {
                addToValidate('EditView', 'colormatch_type_c', 'enum', true, colormatchTypeLabel)
            } else {
                removeFromValidate('EditView', 'colormatch_type_c');
            }

            if (e.target.value == 'color_match') {
                let optionsToHide = ['product_master', 'product_version', 'pigment', 'additive', 'resin'];

                $("div[data-label='LBL_COLORMATCH_TYPE']").text('\nColormatch Type:');
                $("#colormatch_type_c option").each( function() {
                    optionsToHide.includes($(this).val()) ? $(this).hide() : $(this).show();
                });
            } else if (['rematch', 'cost_analysis', 'ld_optimization'].includes(e.target.value)) {
                let optionsToHide = ['chips_quote', 'chips_quote_sample', 'pigment', 'additive', 'resin'];

                $("div[data-label='LBL_COLORMATCH_TYPE']").text('\nRematch Type:');
                $("#colormatch_type_c option").each( function() {
                    optionsToHide.includes($(this).val()) ? $(this).hide() : $(this).show();
                });
            } else if (e.target.value == 'raw_material_evaluation') {
                let optionsToHide = ['chips_quote', 'chips_quote_sample', 'product_master', 'product_version'];

                $("div[data-label='LBL_COLORMATCH_TYPE']").text('\nRaw Material Type:');
                $("#colormatch_type_c option").each( function() {
                    optionsToHide.includes($(this).val()) ? $(this).hide() : $(this).show();
                });
            }

            if (! $("div[data-label='LBL_COLORMATCH_TYPE']").text().includes('<span class="required">*</span>')) {
                $("div[data-label='LBL_COLORMATCH_TYPE']").append('<span class="required">*</span>');
            }
            
            let dropdownOptions = $("#colormatch_type_c option").map( function() {
                return ($(this).css('display') !== 'none') ? $(this).val() : false;
            }).toArray();

            dropdownOptions.includes(colormatchTypeDefaultValue) ? colormatchType.val(colormatchTypeDefaultValue) : colormatchType.val('')
            colormatchTypeDiv.parent().show();

            // Show Product Name and hide Product # (Customer Products) relate field if Type is not Rematch, else swap field display
            if (['rematch', 'cost_analysis', 'ld_optimization'].includes(e.target.value)) {
                if (e.target.value !== 'product_sample') {
                    // Show Product # (Customer Products) relate field and hide Product Name
                    $("#ci_customeritems_tr_technicalrequests_1_name")
                        .closest('.edit-view-row-item.hidden')
                        .removeClass('hidden')
                        .insertBefore($("#name").closest('.edit-view-row-item'));
                    $("#name").closest('.edit-view-row-item').addClass('hidden');
    
                    $("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item').addClass('hidden');
                } else {
                    // Show Product # (Product Master) relate field and hide Product Name
                    $("#tr_technicalrequests_aos_products_2_name")
                        .closest('.edit-view-row-item.hidden')
                        .removeClass('hidden')
                        .insertBefore($("#name").closest('.edit-view-row-item'));
                    $("#name").closest('.edit-view-row-item').addClass('hidden');
    
                    $("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item').addClass('hidden');
                }
            } else {
                if (e.target.value !== 'product_sample') {
                    $("#name")
                        .closest('.edit-view-row-item.hidden')
                        .removeClass('hidden')
                        .insertBefore($("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item'));
                } else {
                    $("#name")
                        .closest('.edit-view-row-item.hidden')
                        .removeClass('hidden')
                        .insertBefore($("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item'));
                }

                $("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item').addClass('hidden');
                $("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item').addClass('hidden');
            }
        }

        if (e.target.value === 'lab_items') {
            removeFromValidate('EditView', 'tr_technicalrequests_opportunities_name');
            removeFromValidate('EditView', 'tr_technicalrequests_opportunitiesopportunities_ida');

            let divField = $(`div[field='tr_technicalrequests_opportunities_name']`).prev();
            let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
            divField.text(divFieldNewLabel);

            $(`#tr_technicalrequests_opportunities_name`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
        } else {
            addToValidate('EditView', 'tr_technicalrequests_opportunities_name', 'relate', true,'Opportunities' );
            addToValidateBinaryDependency('EditView', 'tr_technicalrequests_opportunities_name', 'alpha', true,'No match for field: Opportunities', 'tr_technicalrequests_opportunitiesopportunities_ida');

            let divField = $(`div[field='tr_technicalrequests_opportunities_name']`).prev();
            let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
            divField.text(divFieldNewLabel).append('<span class="required">*</span>');
        }

        // If Type is empty, show Product Name field and hide Product # (Customer Products) relate field
        if (e.target.value.length <= 0) {
            $("#name")
                .closest('.edit-view-row-item.hidden')
                .removeClass('hidden')
                .insertBefore($("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item'));
            $("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item').addClass('hidden');

            $("#name")
                .closest('.edit-view-row-item.hidden')
                .removeClass('hidden')
                .insertBefore($("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item'));
            $("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item').addClass('hidden');
        }

        showOrHideColormatchAndRegulatoryTabs(e.target.value, approval_stage_val);

        // If field is hidden, remove validation, else, add to validate
        if ($("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item.hidden').length > 0) {
            // Force field values to be empty if field is hidden
            $("#ci_customeritems_tr_technicalrequests_1_name, #ci_customeritems_tr_technicalrequests_1ci_customeritems_ida").val('');

            removeFromValidate('EditView', 'ci_customeritems_tr_technicalrequests_1_name');
            removeFromValidate('EditView', 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida');
        } else {
            let productNumberFieldLabel = $("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item').find('.label').text().trim().split(":")[0];

            addToValidate('EditView', 'ci_customeritems_tr_technicalrequests_1_name', 'relate', true, productNumberFieldLabel );
            addToValidateBinaryDependency('EditView', 'ci_customeritems_tr_technicalrequests_1_name', 'alpha', true,`No match for field: ${productNumberFieldLabel}`, 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida' );
        }

        if ($("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item.hidden').length > 0) {
            // Force field values to be empty if field is hidden
            $("#tr_technicalrequests_aos_products_2_name, #tr_technicalrequests_aos_products_2aos_products_idb").val('');

            removeFromValidate('EditView', 'tr_technicalrequests_aos_products_2_name');
            removeFromValidate('EditView', 'tr_technicalrequests_aos_products_2aos_products_idb');
        } else {
            let productNumberFieldLabel = $("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item').find('.label').text().trim().split(":")[0];

            addToValidate('EditView', 'tr_technicalrequests_aos_products_2_name', 'relate', true, productNumberFieldLabel );
            addToValidateBinaryDependency('EditView', 'tr_technicalrequests_aos_products_2_name', 'alpha', true,`No match for field: ${productNumberFieldLabel}`, 'tr_technicalrequests_aos_products_2aos_products_idb' );
        }
    }).trigger('change');
}

/*
const onTabChange = () => {
    $("#EditView_tabs li[role='presentation'] a[data-toggle='tab']").on('click', function() {
        let self = $(this);
        let tabLabel = self.text().trim();
        let specialTesting = $("#special_testing_c");

        if (tabLabel === 'Quality') {
            populateSpecialTesting(self);
            specialTesting
                .on('change', (e) => onSpecialTestingChanged(e, self))
                .find(`option[value='yes']`)
                .css('display', 'none')
                .parent().after( () => {
                    if (! document.getElementById('special-testing-note')) {
                        return "<div style='margin: 4px;' id='special-testing-note' class='text-info'>Note: Select at least one test to set the value to 'Yes' else set it to 'No'.</div>";
                    }
                });
        }
    });
}

const populateSpecialTesting = (activeTab) => {
    let specialTesting = $("#special_testing_c");
    let tabNumber = $(activeTab).attr('id').match(/\d+/)[0];
    let tabCheckboxes = $(`#tab-content-${tabNumber}`).find("input[type='checkbox']");
    
    $(tabCheckboxes).on('change', function() {
        let tabCheckedCheckboxes = $(`#tab-content-${tabNumber}`).find("input[type='checkbox']:checked");

        specialTesting.val(
            (tabCheckedCheckboxes.length > 0) ? 
                'yes' : (specialTesting.val() === 'yes') ? 
                '' : specialTesting.val()
        );
    });
}

const onSpecialTestingChanged = (e, activeTab) => {
    let self = $(e.currentTarget);
    let tabNumber = $(activeTab).attr('id').match(/\d+/)[0];
    let tabCheckedCheckboxes = $(`#tab-content-${tabNumber}`).find("input[type='checkbox']:checked");

    (self.val() !== 'yes') ? tabCheckedCheckboxes.trigger('click') : '';
}
*/

const onReqCompletionDateChanged = () => {
    let prevReqCompletionDate = '';

    if ($("input[name='record']").val()) {
        prevReqCompletionDate = $("#req_completion_date_c").val();
        globalAllowReqCompDateCheck = true;
    }

    setInterval(() => {
        let newReqCompletionDate = $("#req_completion_date_c").val();

        if(globalAllowReqCompDateCheck){

            if (
                $('#approval_stage').val() !== 'understanding_requirements' && 
                (prevReqCompletionDate && prevReqCompletionDate !== newReqCompletionDate)
            ) {
                let divField = $(`div[field='technical_request_update']`).prev();
                
                if (! checkValidate('EditView', 'technical_request_update')) {
                    addToValidate('EditView', 'technical_request_update', 'varchar', true, 'Technical Request Update' ); 
    
                    let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                    divField.text(divFieldNewLabel).append('<span class="required">*</span>')
                        
                }
    
                let divFieldValidationMessageElement = divField.parent().find('.required.validation-message');
    
                if (divFieldValidationMessageElement.text().includes('Missing required field:')) {
                    divFieldValidationMessageElement.text('Provide an update since the Req Completion Date has been modified')
                }
                
            } else {
                if (checkValidate('EditView', 'technical_request_update')) {
                    removeFromValidate('EditView', 'technical_request_update');
    
                    let divField = $(`div[field='technical_request_update']`).prev();
                    let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                    divField.text(divFieldNewLabel);
    
                    $(`#technical_request_update`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
                }
            }
        }

        //OnTrack #1455
        if(prevReqCompletionDate != newReqCompletionDate){
            prevReqCompletionDate = newReqCompletionDate;

            let today = new Date().toLocaleDateString()
            let dToday = new Date(today);
            let strNewReqCompletionDate = new Date(newReqCompletionDate).toLocaleDateString();
            let dNewReqCompletionDate = new Date(strNewReqCompletionDate);

            if(dNewReqCompletionDate <= dToday){
                alert('Please choose future date!');
                $("#req_completion_date_c").val('');
            }
        }
    
    }, 100);
}

const handleDevApprovedCheckIfColorMatcherExists = (buttonEvent) => {
    let recordId = $("input[name='record'][type='hidden']").val();

    if (recordId.length > 0) {
        $.post('index.php?', {
            module: 'TR_TechnicalRequests',
            action: 'check_if_colormatcher_exists',
            to_pdf: true,
            recordId: recordId
        }).done( (response) => {
            const { data } = JSON.parse(response);

            if (! data) {
                if (! alert("You must have a Color Matcher assigned to this Technical Request before you can approve for development!")) {
                    window.onbeforeunload = () => {}
                    window.location.href = `/index.php?module=TR_TechnicalRequests&action=DetailView&record=${recordId}`;
                }
            } else {
                handleTabAndFieldsValidationWithSubmit(buttonEvent);
            }

            return data;
        });
    }
}

const handleDevCompleteCheckIfProductMasterExists = (buttonEvent) => {
    let recordId = $("input[name='record'][type='hidden']").val();

    if (recordId.length > 0) {
        $.post('index.php?', {
            module: 'TR_TechnicalRequests',
            action: 'check_if_product_master_exists',
            to_pdf: true,
            recordId: recordId
        }).done( (response) => {
            const { data } = JSON.parse(response);

            if (! data) {
                if (! alert("You must have a Product Master associated to this Technical Request before you can set the development to complete!")) {
                    window.onbeforeunload = () => {}
                    window.location.href = `/index.php?module=TR_TechnicalRequests&action=DetailView&record=${recordId}`;
                }
            } else {
                handleTabAndFieldsValidationWithSubmit(buttonEvent);
            }

            return data;
        });
    }
}

const handleApprovePMAndColorMatcherExists = (buttonEvent) => {
    let recordId = $("input[name='record'][type='hidden']").val();

    if (recordId.length > 0) {
        $.post('index.php?', {
            module: 'TR_TechnicalRequests',
            action: 'check_if_pm_and_colormatcher_exists',
            to_pdf: true,
            recordId: recordId
        }).done( (response) => {
            const { data } = JSON.parse(response);

            if ((! data?.pm_exists) || (! data?.colormatcher_exists)) {
                if (! alert("You must have a Product Master associated and a Color Matcher assigned to this Technical Request before you can approve for development!")) {
                    window.onbeforeunload = () => {}
                    window.location.href = `/index.php?module=TR_TechnicalRequests&action=DetailView&record=${recordId}`;
                }
            } else {
                handleTabAndFieldsValidationWithSubmit(buttonEvent);
            }

            return data;
        });
    }
}

const handleDevelopmentNewDistroExists = (buttonEvent) => {
    let recordId = $("input[name='record'][type='hidden']").val();

    if (recordId.length > 0) {
        $.post('index.php?', {
            module: 'TR_TechnicalRequests',
            action: 'check_if_distro_exists',
            to_pdf: true,
            recordId: recordId
        }).done( (response) => {
            const { data } = JSON.parse(response);

            if (! data) {
                if (! alert("You must have a distribution before you can submit for development!")) {
                    window.onbeforeunload = () => {}
                    window.location.href = `/index.php?module=TR_TechnicalRequests&action=DetailView&record=${recordId}`;
                }
            } else {
                handleTabAndFieldsValidationWithSubmit(buttonEvent);
            }

            return data;
        });
    }
}

const showOrHideColormatchAndRegulatoryTabs = (targetVal, stageVal) => {
    
    let colormatchTabRequiredFields = [];
    let regulatoryTabRequiredFields = [];
    let acceptedTypeList = ['color_match', 'rematch', 'cost_analysis', 'ld_optimization'];

    $("#tab-content-1 .edit-view-row-item").find('.required:not([style*="display: none"])').each( (index, val) => {
        $(val).closest('.edit-view-row-item').find('.edit-view-field').each((index, val) => {
            colormatchTabRequiredFields.push($(val).attr('field'));
        });
    });

    $("#tab-content-2 .edit-view-row-item").find('.required:not([style*="display: none"])').each( (index, val) => {
        $(val).closest('.edit-view-row-item').find('.edit-view-field').each((index, val) => {
            colormatchTabRequiredFields.push($(val).attr('field'));
        });
    });

    if (! acceptedTypeList.includes(targetVal)) {
        $('.nav.nav-tabs a#tab1, .nav.nav-tabs a#tab2').addClass('hidden');
        
        colormatchTabRequiredFields.forEach( (val) => {
            (checkValidate('EditView', val)) ? removeFromValidate('EditView', val) : null;
        });

        regulatoryTabRequiredFields.forEach( (val) => {
            (checkValidate('EditView', val)) ? removeFromValidate('EditView', val) : null;
        });
    } else {
        $('.nav.nav-tabs a#tab1, .nav.nav-tabs a#tab2').removeClass('hidden');

        if (stageVal !== 'understanding_requirements') {
            colormatchTabRequiredFields.forEach( (val) => {
                let fieldType = $(`#${val}`).parent().attr('type');
                let fieldLabel =  $(`#${val}`).closest('.edit-view-row-item')
                    .find('.label')
                    .text()
                    .trim()
                    .replaceAll('*', '')
                    .replaceAll(':', '');
                
                addToValidate('EditView', val, fieldType, true, fieldLabel);
            });

            regulatoryTabRequiredFields.forEach( (val) => {
                let fieldType = $(`#${val}`).parent().attr('type');
                let fieldLabel =  $(`#${val}`).closest('.edit-view-row-item')
                    .find('.label')
                    .text()
                    .trim()
                    .replaceAll('*', '')
                    .replaceAll(':', '');

                addToValidate('EditView', val, fieldType, true, fieldLabel);
            });
        } else {
            colormatchTabRequiredFields.forEach( (val) => {
                (checkValidate('EditView', val)) ? removeFromValidate('EditView', val) : null;
            });
    
            regulatoryTabRequiredFields.forEach( (val) => {
                (checkValidate('EditView', val)) ? removeFromValidate('EditView', val) : null;
            });
        }
    }
}

// If site field is empty or stage is Understanding Requirements and status is Draft or stage is Development and status is New, enable site field, else disable it
const enableDisableSiteField = () => {
    if (
        $("#site").val().length <= 0 ||
        ($("#approval_stage").val() == 'understanding_requirements' && $("#status").val() == 'in_process') ||
        ($("#approval_stage").val() == 'development' && $("#status").val() == 'new')
    ) {
        $("#site").removeClass('custom-readonly');
    } else {
        $("#site").addClass('custom-readonly');
    }
}

// If not Understanding Requirements and Development OR Development and not New, type is Production Rematch (rematch) and type Rematch type (colormatch_type_c) is not empty
const handleRematchTypeEnableDisable = async () => {
    let stageVal = $("#approval_stage").val();
    let statusVal = $("#status").val();
    let typeVal = $("#type").val();
    let colormatchType = $("#colormatch_type_c");
    let isRematch = typeVal == 'rematch' ? true : false;

    if (isRematch) {
        if (stageVal == 'development' && statusVal == 'new') {
            let productMasterExists = await handleCheckIfProductMasterExists();
                
            (productMasterExists && colormatchType.val().length > 0) ?
                colormatchType.addClass('custom-readonly') : 
                colormatchType.removeClass('custom-readonly');
        } else if (stageVal !== 'understanding_requirements') {
            colormatchType.val().length > 0 ? colormatchType.addClass('custom-readonly') : colormatchType.removeClass('custom-readonly');
        } else {
            colormatchType.removeClass('custom-readonly');
        }
    } else {
        colormatchType.removeClass('custom-readonly');
    }
}

const handleCheckIfProductMasterExists = async () => {
    let recordId = $("input[name='record'][type='hidden']").val();
    let productMasterExists = false;

    if (recordId.length > 0) {
        await $.post('index.php?', {
            module: 'TR_TechnicalRequests',
            action: 'check_if_product_master_exists',
            to_pdf: true,
            recordId: recordId,
        }).success( (response) => {
            const { data } = JSON.parse(response);
            productMasterExists = (! data) ? false : true;
        }).error( (errorResponse) => {
            console.log(errorResponse);
        });
    }
    
    return productMasterExists;
}

const onOpacityLevelChanged = () => {
    let approval_stage_val = $('#approval_stage').val();

    let fieldsToValidate = [
        { name: 'thickness_c', type: 'varchar', label: 'Thickness'}, 
    ];

    $("#opacity_level_c").on('change', (e) => {
        if (['opaque'].includes(e.target.value)) {
            $.each(fieldsToValidate, (index, field) => {
                if (approval_stage_val !== 'understanding_requirements') {
                    addToValidate('EditView', field.name, field.type, true, field.label);
                } else {
                    removeFromValidate('EditView', field.name);
                }
                
                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel).append('<span class="required">*</span>');
            });
        } else {
            $.each(fieldsToValidate, (index, field) => {
                removeFromValidate('EditView', field.name);

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel);

                $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
            });
        }
    }).trigger('change');
}

const retrieveFieldsToMap = () => {
    let requiredFieldsObj = jQuery("div.label:has(span.required)").next("div.edit-view-field");
    let stageVal = jQuery('#approval_stage').val();
    let fieldsArray = {
        'mandatoryFields': [],
        'nonMandatoryFields': [],
    };

    switch (stageVal) {
        case 'understanding_requirements':
            mandatoryFieldNameList = ['type', 'name', 'tr_technicalrequests_opportunities_name', 'tr_technicalrequests_accounts_name', 'distro_type_c'];    
            break;
        case 'closed_rejected':
            mandatoryFieldNameList = ['name'];
            break;
        default:
            // Default needs to be empty an empty array so that all mandatory fields are pushed to the fieldsArray.mandatoryFields array
            mandatoryFieldNameList = [];
            break;
    }

    // If Understanding Requirements or Closed Rejected, check if Product # (Customer Products) relate field is hidden, if true, remove from mandatory list and add Product Name to mandatoryFieldNameList, else swap field behaviors
    if (['understanding_requirements', 'closed_rejected'].includes(stageVal)) {
        if ($("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item.hidden').length === 0) {
            mandatoryFieldNameList = mandatoryFieldNameList.filter((field) => (! ['name', 'tr_technicalrequests_aos_products_2_name', 'tr_technicalrequests_aos_products_2aos_products_idb'].includes(field)));
            mandatoryFieldNameList.push('ci_customeritems_tr_technicalrequests_1_name', 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida');
        }

        if ($("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item.hidden').length === 0) {
            mandatoryFieldNameList = mandatoryFieldNameList.filter((field) => (! ['name', 'ci_customeritems_tr_technicalrequests_1_name', 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida'].includes(field)));
            mandatoryFieldNameList.push('tr_technicalrequests_aos_products_2_name', 'tr_technicalrequests_aos_products_2aos_products_idb');
        }

        if ($("#ci_customeritems_tr_technicalrequests_1_name").closest('.edit-view-row-item.hidden').length > 0 && $("#tr_technicalrequests_aos_products_2_name").closest('.edit-view-row-item.hidden').length > 0) {
            mandatoryFieldNameList = mandatoryFieldNameList.filter((field) => (! ['ci_customeritems_tr_technicalrequests_1_name', 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida', 'tr_technicalrequests_aos_products_2_name', 'tr_technicalrequests_aos_products_2aos_products_idb'].includes(field)));
            mandatoryFieldNameList.push('name');
        }
    }
    

    // Get the field name and push it into the array
    for (const [key, el] of Object.entries(requiredFieldsObj)) {
        let fieldName = jQuery(el).attr('field');

        if (fieldName != undefined && parseInt(key) >= 0) {
            // If mandatoryFieldNameList is empty, push all fields as mandatory, else filter mandatory and non-mandatory fields based on mandatoryFieldNameList data
            if (mandatoryFieldNameList.length <= 0) {
                let returnObj = {};
                returnObj['name'] = fieldName;
                returnObj['type'] = jQuery(el).attr('type');
                returnObj['label'] = jQuery(el).prev().text().trim().split(":")[0];
                returnObj['field'] = jQuery(el);
                fieldsArray.mandatoryFields.push(returnObj);
            } else {
                if (! mandatoryFieldNameList.includes(fieldName)) {
                    let returnObj = {};
                    returnObj['name'] = fieldName;
                    returnObj['type'] = jQuery(el).attr('type');
                    returnObj['label'] = jQuery(el).prev().text().trim().split(":")[0];
                    returnObj['field'] = jQuery(el);
                    fieldsArray.nonMandatoryFields.push(returnObj);
                } else {
                    let returnObj = {};
                    returnObj['name'] = fieldName;
                    returnObj['type'] = jQuery(el).attr('type');
                    returnObj['label'] = jQuery(el).prev().text().trim().split(":")[0];
                    returnObj['field'] = jQuery(el);
                    fieldsArray.mandatoryFields.push(returnObj);
                }
            }
        }
    }

    return fieldsArray;
}

const handleOpportunityFieldEnableDisable = () => {
    let isCopyFull = $("#custom_rematch_type").val() == 'copy_full' ? true : false;

    if (! isCopyFull) {
        return true;
    }

    let opportunityId = $("#tr_technicalrequests_opportunitiesopportunities_ida");
    let opportunityName = $("#tr_technicalrequests_opportunities_name");

    if (opportunityId.val().length > 0 && opportunityName.val().length > 0) {
        opportunityName.addClass('custom-readonly').parent().find('button[id*="tr_technicalrequests_opportunities_name"]').addClass('hidden');
    } else {
        opportunityName.removeClass('custom-readonly').parent().find('button[id*="tr_technicalrequests_opportunities_name"]').removeClass('hidden');
    };
}

const handleEstCompletionDateValidation = () => {
    let fieldsToValidate = [
        { name: 'est_completion_date_c', type: jQuery("#est_completion_date_c").attr('type'), label: jQuery("div[field='est_completion_date_c']").prev().text().trim().split(":")[0] }, 
    ];
    
    let stageVal = jQuery('#approval_stage').val();
    let statusVal = jQuery("#status").val();

    if (! ['understanding_requirements', 'closed_rejected'].includes(stageVal)) {
        if ((stageVal !== 'development' || (stageVal == 'development' && statusVal == 'new'))) {
            $.each(fieldsToValidate, (index, field) => {
                removeFromValidate('EditView', field.name);

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel);

                $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
            });
        } else {
            $.each(fieldsToValidate, function(index, field) {
                customDateFieldValidation(field.name);
                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel).append('<span class="required">*</span>');
            });
        }
    } else {
        $.each(fieldsToValidate, (index, field) => {
            removeFromValidate('EditView', field.name);

            let divField = $(`div[field='${field.name}']`).prev();
            let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
            divField.text(divFieldNewLabel);

            $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
        });
    }

    //OnTrack #1455
    let prevEstCompletionDateVal = $("#est_completion_date_c").val();
    setInterval(() => {
        let newEstCompletionDateVal = $("#est_completion_date_c").val();

        if(prevEstCompletionDateVal != newEstCompletionDateVal){
            prevEstCompletionDateVal = newEstCompletionDateVal;

            let today = new Date().toLocaleDateString()
            let dToday = new Date(today);
            let strNewEstCompletionDateVal = new Date(newEstCompletionDateVal).toLocaleDateString();
            let dEstCompletionDate = new Date(strNewEstCompletionDateVal);

            if(dEstCompletionDate <= dToday){
                alert('Please choose future date!');
                $("#est_completion_date_c").val('');
            }
        }
    }, 500);
}

const handleApproveDistroAndTRLabItemsCompleted = () => {
    let stageVal = $("#approval_stage").val();
    let statusVal = $("#status").val();
    let recordId = $("input[name='record'][type='hidden']").val();

    if (stageVal === 'development' && statusVal === 'development_complete') {
        if (recordId.length > 0) {
            $.post('index.php?', {
                module: 'TR_TechnicalRequests',
                action: 'check_if_distro_and_tr_lab_items_completed',
                to_pdf: true,
                recordId: recordId
            }).done( (response) => {
                const { data } = JSON.parse(response);
                
                if (data?.incomplete_distro_lab_items.length > 0 || data?.incomplete_tr_lab_items.length > 0) {
                    data.incomplete_distro_lab_items.sort();
                    data.incomplete_tr_lab_items.sort();
                    
                    let alertMsg = 'Please be sure to close the following out before proceeding: \n\n';

                    if (data.incomplete_distro_lab_items.length > 0) {
                        alertMsg += `Distro Lab Items: \n ${data.incomplete_distro_lab_items.join('\n ')} \n\n`;
                    }
                    
                    if (data.incomplete_tr_lab_items.length > 0) {
                        alertMsg += `TR Lab Items: \n ${data.incomplete_tr_lab_items.join('\n ')}`;
                    }

                    alert(alertMsg);

                    $("#status").val(data?.status !== statusVal ? data?.status : 'new'); // If current value is development_complete set to 'new', else set to previous value
                }
            });
        }
    }
}

// Applicable to Date fields that should not allow selection of Past Dates or dates before current date
const customDateFieldValidation = (fieldName) => {
    YAHOO.util.Event.addListener(fieldName, 'change', () => {
        addToValidateCallback(
            'EditView', // Form Name
            fieldName, // field name
            'date', // Field type
            true, // Is required
            "", // Message
            (formName, nameIndex) => { 
                let result = false;
                let newValue = jQuery(`#${nameIndex}`).val();
                let dateVal = new Date(newValue);
                let dateNow = new Date();
                dateNow.setHours(0, 0, 0, 0);
                
                if (dateVal < dateNow) {
                    // clear_all_errors(); 
                    $(`#${fieldName}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
                    add_error_style(formName, nameIndex, "Invalid Date: Cannot set past date");
                    result = false;
                } else {
                    result = true;
                }
        
                return result;
        });
    });
}

const handleTabMandatoryIndicator = () => {
    jQuery('.tab-pane-NOBOOTSTRAPTOGGLER').each( (index, item) => {
        let tabPane = jQuery(item);
        let validationMessagesObj= tabPane.find('.validation-message:not([style*="display: none"])');
        let tabPaneId = tabPane.attr('id');
        let tabPaneIndex = tabPaneId.substring(12); //count from tab pane id: tab-content-
        let navTab = jQuery('#EditView_tabs .nav-tabs > li').eq(tabPaneIndex);

        if (validationMessagesObj != null && validationMessagesObj.length > 0) {
            navTab.find('a').addClass('text-red-important');
        } else {
            navTab.find('a').removeClass('text-red-important');
        }
    });
}

const handleResinColorFieldsEnableDisable = () => {
    const recordId = jQuery("input[name=record]").val()
    // const aos_product_master = $("#tr_technicalrequests_aos_products_2aos_products_idb").val()
    
    if (recordId) {
        jQuery.ajax({
            type: "GET",
            url: "index.php?module=TR_TechnicalRequests&action=check_tr_product_master&to_pdf=1",
            data: {'record_id': recordId},
            dataType: 'json',
            success: function(result){
                if(result.success && Array.isArray(result.data) && result.data.length > 0) {
                   jQuery('#color_c, #resin_compound_type_c').addClass('custom-readonly');
                } else {
                    jQuery('#color_c, #resin_compound_type_c').removeClass('custom-readonly');
                }
            },
            error: function(result){
                console.log(result);
            }
        });

    }
}

const handleTypeFieldDropdownOptions = () => {
    let opportunityId = jQuery('#tr_technicalrequests_opportunitiesopportunities_ida').val();
    let recordId = jQuery("input[name=record]").val()

    jQuery.ajax({
        type: "GET",
        url: "index.php?module=TR_TechnicalRequests&action=get_technicalrequest_type_dropdown_list_by_opportunity&to_pdf=1",
        data: {'opportunity_id': opportunityId, 'record_id': recordId},
        dataType: 'json',
        success: function(result){
            let { data } = result;
            let { type_value, type_options } = data;

            if (type_options) {
                jQuery("#type")
                    .find('option')
                    .remove()
                    .end()
                    .append(type_options)
                    .trigger('change')
                    .val(type_value);
            }
        },
        error: function(result){
            console.log(result);
        }
    });
}

const handleEnableColorMatchAndRegulatoryTabFields = (callback) => {
    let recordId = jQuery("input[name=record]").val();

    jQuery.ajax({
        type: "GET",
        url: "index.php?module=TR_TechnicalRequests&action=check_tr_item_colormatch_status&to_pdf=1",
        data: {'record_id': recordId},
        dataType: 'json',
        success: function(result){
           let { data } = result;

           if (data.is_admin === '0') {

               if (data.has_colormatch === true && data.is_complete === true && data.tr_bean.stage === 'development' && ['new', 'in_process', 'approved'].includes(data.tr_bean.status)) {
                   callback.apply(this,[]);
               } else if (['sampling', 'production_trial', 'award_eminent', 'closed_won', 'closed_lost', 'closed_rejected'].includes(data.tr_bean.stage)) {
                   callback.apply(this,[]);
               } else {
                   // do nothing
               }
           }
        },
        error: function(result){
            console.log('err', result);
        }
    });
}

const disableFieldsInTab = () => {
    let selectedTab = ['ColorMatch', 'Regulatory']; // tabs to manipulate
    let navigationCount = jQuery('#EditView div.tab-content').children().length; // count number of tabs in editview
    let tabClass = [];
    // set an array for nav button -> nav content id pairings
    for (let i = 0; i < navigationCount; i++) {
        tabClass[`tab${i}`] = `#tab-content-${i}`;
    }

    for (let index in selectedTab) {
        let tab = selectedTab[index];
        let tabObjectId = jQuery('#EditView ul.nav-tabs li > a:contains('+tab+')').attr('id');

        jQuery(tabClass[tabObjectId]).find('input:not(hidden), select, textarea').each(function() {
            jQuery(this).addClass('custom-readonly');
        })
    }

}

const handleAccountIdChanged = () => {
    let account_id_prev = $("#tr_technicalrequests_accountsaccounts_ida").val();

    setInterval(() => {
        let account_id_new = $("#tr_technicalrequests_accountsaccounts_ida").val();
        let account_name = $("#tr_technicalrequests_accounts_name").val();

        if (account_name.length === 0) {
            $("#tr_technicalrequests_accountsaccounts_ida").val('');
        }

        if (account_id_prev != account_id_new) {
            let popupBtn = $("#btn_ci_customeritems_tr_technicalrequests_1_name");
            let popupBtnOnClickEvent = popupBtn.attr('onclick');

            popupBtnOnClickEvent = popupBtnOnClickEvent.replace(`&account_id=${account_id_prev}`, `&account_id=${account_id_new}`);
            popupBtn.attr('onclick', popupBtnOnClickEvent);

            account_id_prev = account_id_new;

            handleProductNumberAutocomplete(account_id_prev);

            jQuery("#ci_customeritems_tr_technicalrequests_1_name").val('');
            jQuery("#ci_customeritems_tr_technicalrequests_1ci_customeritems_ida[type=hidden]").val('');

        }
    }, 500)
}

const handleProductNumberAutocomplete = (accountId) => {
    accountId = accountId.length > 0 ? accountId : "NULL";

    sqs_objects['EditView_ci_customeritems_tr_technicalrequests_1_name']['conditions'][1] = {
        name: "ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida",
        op: "equal",
        value: accountId
    };

    sqs_objects['EditView_ci_customeritems_tr_technicalrequests_1_name']['group'] = 'and';

    SUGAR.util.doWhen(
        "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['EditView_ci_customeritems_tr_technicalrequests_1_name']) != 'undefined'",
        enableQS
    );
}