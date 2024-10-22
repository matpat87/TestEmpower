var isSubmitButtonClicked = false;
var currentClosedDate = null;
var isAllowEdit = true;
$(document).ready(function(e){
    currentClosedDate = $('#closed_date_c').val();

    var fieldValues = {
        'sales_stage': $(".edit-view-field #sales_stage").val(),
        'probability': $(".edit-view-field #probability").val(),
        'status': $(".edit-view-field #status_c").val(),
        'industry': $('select#industry_c').val(),
        'sub_industry': $('select#sub_industry_c').val(),
        'record_id': $('input[name=record]').val(),
    };

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

    if (check_form('ConvertLead')) {
        customValidateAvgSellPrice('ConvertLead', 'Opportunitiesavg_sell_price_c', 'Avg Sell Price ($/lb)');
    }

    customValidateAvgSellPrice();

    var disableCalculateFieldsInterval;
    

    disableCalculateFieldsInterval = setInterval(function(){
        DisableCalculateFields(disableCalculateFieldsInterval);
    }, 900)

    AmountJS();
    onAccountChanged();

    handleEnableDisableSalesStageChangedFunction();
    removeFromValidate('EditView', 'oppid_c'); // Removed required validation on Create Page
    

    // Deprecated in Ontrack 1507
    // $("select#industry_c")
    //     .on("change", (e) => {
    //         var obj_values = {
    //             ...fieldValues,
    //             'industry': e.target.value
    //         }
    //         populateSubIndustryDropdown(obj_values);
    //     }).trigger("change");

    $("select#sub_industry_c")
        .on("change", (e) => {
            var obj_values = {
                ...fieldValues,
                'sub_industry': e.target.value
            }
            
            populateIndustryDropdown(obj_values);
        }).trigger("change");

});

function onAccountChanged()
{
    var account_id_prev = $('#account_id').val();

    setInterval(function(){
        var account_id_curr = $('#account_id').val();

        if(account_id_curr != account_id_prev)
        {
            $.ajax({
                type: "POST",
                url: "index.php?module=Opportunities&action=get_oem&to_pdf=1",
                data: {'account_id': account_id_curr},
                dataType: 'json',
                success: function(result){
                    if(result.data != null && result.data.oem_account_id != null)
                    {
                        $('#oem_account_c').val(result.data.oem_account_name);
                        $('#account_id_c').val(result.data.oem_account_id);
                    }
                    else{
                        $('#oem_account_c').val('');
                        $('#account_id_c').val('');
                    }
                },
                error: function(result){
                    console.log(result);
                    alert('error');
                }
            });

            account_id_prev = account_id_curr;
        }
    }, 200);
}

function DisableCalculateFields(disableCalculateFieldsInterval)
{
    var result = false;
    var opportunityID = $('#opportunity_id').val();
    var postData = { 'opportunity_id': opportunityID };
    var date_modified = $('#date_modified').val();
    var previousDate = null;
    var newDate = null;
    
    if(!isSubmitButtonClicked && opportunityID != null && opportunityID != ''){
        $.ajax({
            type: "POST",
            url: "index.php?module=Opportunities&action=get_trs&to_pdf=1",
            data: postData,
            dataType: 'json',
            success: function(jsonResult){

                if(jsonResult.success)
                {
                    var opportunity = (jsonResult.data.opportunity != null) ? jsonResult.data.opportunity : null;
                    date_modified = $('#date_modified').val();
                    previousDate = new Date(date_modified);
                    newDate = new Date(opportunity.date_modified);

                    if(opportunity != null && previousDate < newDate)
                    {
                        if(jsonResult.data != null && jsonResult.data.trs_count > 0){
                            result = true;
                            $('#avg_sell_price_c, #annual_volume_lbs_c, #probability_prcnt_c, #Opportunitiesavg_sell_price_c').attr('readonly', 'readonly');
                            $('#sales_stage, #status_c').attr('disabled', 'true');
                            $('#avg_sell_price_c, #annual_volume_lbs_c, #probability_prcnt_c, #sales_stage, #status_c, #Opportunitiesavg_sell_price_c')
                                .attr('style', 'background: rgb(248, 248, 248); border: 1px solid rgb(226, 231, 235); cursor: not-allowed;');
                            $('#avg_sell_price_c, #Opportunitiesavg_sell_price_c').val(opportunity.avg_sell_price_c);
                            $('#annual_volume_lbs_c').val(opportunity.annual_volume_lbs_c);
                            $('#probability_prcnt_c').val(opportunity.probability_prcnt_c);
                            $('#amount').val(opportunity.amount);
                            $('#sales_stage').val(opportunity.sales_stage);
                            isAllowEdit = false;
                            
                        }
                        else
                        {
                            $('#avg_sell_price_c, #Opportunitiesavg_sell_price_c').val('$0.00');
                            $('#annual_volume_lbs_c').val('0');
                            $('#probability_prcnt_c').val('0');
                            $('#amount').val('$0.00');
                            $("#sales_stage").val($("#sales_stage option:first").val());
                            $("#sales_stage").change();
                            $('#avg_sell_price_c, #annual_volume_lbs_c, #probability_prcnt_c, #Opportunitiesavg_sell_price_c').removeAttr('readonly');
                            $('#sales_stage, #status_c').removeAttr('disabled');
                            $('#avg_sell_price_c, #annual_volume_lbs_c, #probability_prcnt_c, #sales_stage, #status_c, #Opportunitiesavg_sell_price_c').removeAttr('style');
                            isAllowEdit = true;
                            // InitializeSalesStage(false);
                        }

                        $('#date_modified').val(opportunity.date_modified);
                    }
                }
            },
            error: function(result){
                console.log(result);
            }
        });
    }

    return result;
}

function InitializeSalesStage(isWithTR = false)
{
    var sales_stage_obj = $('#sales_stage');
    var current_sales_staege_value = sales_stage_obj.val();
    var allowedSalesStageWithTR = ['IdentifyingOpportunity', 'UnderstandingRequirements', 'SolutionDevelopment', 
        'QuotingProposing', 'ProductionTrialOrder', 'AwardEminent', 'Closed'];
    sales_stage_obj.empty();
    var isAllow = false;

    for(var i = 0; i < sales_stage_dom.length; i++)
    {
        var sales_stage_dom_val = sales_stage_dom[i];
        isAllow = false;

        if(!isWithTR)
        {
            if(sales_stage_dom_val[0] != 'Closed')
            {
                isAllow = true;
            }
        }
        else
        {
            if(allowedSalesStageWithTR.includes(sales_stage_dom_val[0]))
            {
                isAllow = true;
            }
        }

        if(isAllow){
            sales_stage_obj.append('<option value='+ sales_stage_dom_val[0] +'>'+ sales_stage_dom_val[1] +'</option>');
        }
        
    }

    console.log(current_sales_staege_value);
    sales_stage_obj.val(current_sales_staege_value);
}

function AmountJS()
{   
    
    $("#amount, #amount_weighted_c, #Opportunitiesamount")
        .attr('readonly', 'readonly')
        .css('background', '#f8f8f8')
        .css('border', '1px solid #e2e7eb')
        .css('cursor', 'not-allowed');

    $("#annual_volume_lbs_c, #avg_sell_price_c, #Opportunitiesavg_sell_price_c, #Opportunitiesannual_volume_lbs_c")
    .on('blur', function() {

        if ($('#annual_volume_lbs_c').html() != undefined) {
            calculateOpportunityAmount();
        } else {
            calculateOpportunityAmount('#Opportunitiesavg_sell_price_c', '#Opportunitiesannual_volume_lbs_c');
            
            
        }
    })
    .on('focus', function() {
        $(this).select();
    })
}

function customValidateAvgSellPrice(formname, fieldname, label)
{
    min = 0;
    max = 999.99;
    formname = formname || 'EditView';
    fieldname = fieldname || 'avg_sell_price_c'
    label = ($("div[data-label='LBL_AVG_SELL_PRICE'").html() != undefined) 
        ? $("div[data-label='LBL_AVG_SELL_PRICE'").html().trim().replace(/:/g, '')
        : label;

    addToValidate(formname, fieldname, 'currency', true, label);
    validate[formname][validate[formname].length-1][jstypeIndex] = 'range';
    validate[formname][validate[formname].length-1][minIndex] = min;
    validate[formname][validate[formname].length-1][maxIndex] = max;
}

function calculateOpportunityAmount(avg_sell_price_id, annual_volume_lbs_id ) {
    
    var opportunityAmt = 0;
    avg_sell_price_id = avg_sell_price_id ?? '#avg_sell_price_c';
    annual_volume_lbs_id = annual_volume_lbs_id ?? '#annual_volume_lbs_c';

    floatAvgSellPrice = parseFloat($(avg_sell_price_id).val().replace(/,/g, '').replace('$', ''));
    floatAnnualVolLBS = parseFloat($(annual_volume_lbs_id).val().replace(/,/g, ''));
    
    opportunityAmt = isNaN(floatAvgSellPrice * floatAnnualVolLBS) ? 0 : floatAvgSellPrice * floatAnnualVolLBS;

    if(isAllowEdit != undefined){
        $("#amount,#Opportunitiesamount").val('$' + opportunityAmt).blur();
    } 
}

function SalesStageChanged(e) {
    var dropdown = $(e.currentTarget);
    var dropdownVal = dropdown.val();
    var probability_prcnt_c_obj = $('#probability_prcnt_c');
    var convert_lead_probability_prcnt_c_obj = $('#Opportunitiesprobability_prcnt_c');
    var closed_date_c_obj = $('#closed_date_c');

    if(dropdownVal == 'IdentifyingOpportunity')
    {
        probability_prcnt_c_obj.val(0);
        convert_lead_probability_prcnt_c_obj.val(0);
    }
    else if(dropdownVal == 'UnderstandingRequirements')
    {
        probability_prcnt_c_obj.val(1);
        convert_lead_probability_prcnt_c_obj.val(1);
    }
    else if(dropdownVal == 'SolutionDevelopment')
    {
        probability_prcnt_c_obj.val(5);
        convert_lead_probability_prcnt_c_obj.val(5);
        //SolutionDevelopmentClicked(); //Commented as Requested by Steve for Prod Deployment on 7/1/2020
    }
    else if(dropdownVal == 'QuotingProposing')
    {
        probability_prcnt_c_obj.val(10);
        convert_lead_probability_prcnt_c_obj.val(10);
    }
    else if(dropdownVal == 'Sampling')
    {
        probability_prcnt_c_obj.val(25);
        convert_lead_probability_prcnt_c_obj.val(25);
    }
    else if(dropdownVal == 'ProductionTrialOrder')
    {
        probability_prcnt_c_obj.val(50);
        convert_lead_probability_prcnt_c_obj.val(50);
    }
    else if(dropdownVal == 'AwardEminent')
    {
        probability_prcnt_c_obj.val(75);
        convert_lead_probability_prcnt_c_obj.val(75);
    }
    else if(dropdownVal == 'ClosedWon')
    {
        probability_prcnt_c_obj.val(100);
        convert_lead_probability_prcnt_c_obj.val(100);
    }
    else
    {
        probability_prcnt_c_obj.val(0);
        convert_lead_probability_prcnt_c_obj.val(0);
    }

    setClosedDate(closed_date_c_obj, dropdownVal);
    ChooseStatus(dropdownVal);
}

function setClosedDate(fieldObj, stageVal) {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = (month) + "/" + (day) + "/"+ now.getFullYear(); 
    var finalDate = currentClosedDate || null;

    if (stageVal.indexOf("Closed") >= 0) {
        fieldObj.val(finalDate);
        addToValidate('EditView', 'closed_date_c', 'date', true,'Closed Date' );

        var divField = $(`div[field='closed_date_c']`).prev();
        var divFieldNewLabel = divField.text().trim().replaceAll('*', '');
        divField.text(divFieldNewLabel).append('<span class="required">*</span>');

    } else {
        fieldObj.val(null);
        removeFromValidate('EditView', 'closed_date_c');

        var divField = $(`div[field='closed_date_c']`).prev();
        var divFieldNewLabel = divField.text().trim().replaceAll('*', '');
        divField.text(divFieldNewLabel);

        $(`#closed_date_c`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
    }
}

function ChooseStatus(dropdownVal)
{
    console.log('dropdownVal: ' + dropdownVal);
    if(dropdownVal != '')
    {
        var postData = {'stage': dropdownVal, 'opportunity_id': $('input[name="id"]').val()};

        $.ajax({
            type: "POST",
            url: "index.php?module=Opportunities&action=get_status_dropdown&to_pdf=1",
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

function SolutionDevelopmentClicked()
{
    var result = true;
    var opportunity_id = $('#opportunity_id').val();
    var dropdownVal = $('#sales_stage').val();
    

    if(dropdownVal == 'SolutionDevelopment' && (!CheckIfOpportunityHasTR(opportunity_id) || (opportunity_id == null || opportunity_id == '')))
    {
        alert('Sales Stage - Solution Development requires atleast one Technical Request');
        result = false;
    }

    return result;
}

function CheckIfOpportunityHasTR(opportunityID)
{
    var postData = { 'opportunity_id': opportunityID };
    var result = false;

    if(opportunityID != null || opportunityID != ''){
        $.ajax({
            type: "POST",
            url: "index.php?module=Opportunities&action=get_trs&to_pdf=1",
            data: postData,
            async: false,
            dataType: 'json',
            success: function(jsonResult){
                if(jsonResult.success)
                {
                    var opportunity = (jsonResult.data.opportunity != null) ? jsonResult.data.opportunity : null;

                    if(opportunity != null && jsonResult.data.trs_count > 0)
                    {
                        result = true;
                    }
                }
            },
            error: function(result){
                console.log(result);
            }
        });
    }

    return result;
}

function salesStageDynamicDropdownList(fieldValues) {
    switch (fieldValues.sales_stage) {
        case 'QualifyingOpportunity':
            var probabilityOptions = [
                { label: '0% - Exploring Requirements', value: 0 },
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'In Progress', value: 'QualifyingOpportunity_InProgress' }
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'UnderstandingRequirements':
            var probabilityOptions = [
                { label: '1% - Opportunity Qualified', value: 1 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'In Progress', value: 'UnderstandingRequirements_InProgress' }
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'SolutionDevelopment':
            var probabilityOptions = [
                { label: '5% - Requirements Understood', value: 5 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);
            
            var statusOptions = [
                { label: '', value: '' },
                { label: 'In Progress', value: 'SolutionDevelopment_InProgress' }
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'Sampling':
            var probabilityOptions = [
                { label: '10% - Solution Developed', value: 10 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'In Progress', value: 'Sampling_InProgress' },
                { label: 'Sample Failed', value: 'Sampling_SampleFailed' },
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'QuotingProposing':
            var probabilityOptions = [
                { label: '25% - Sample Approved', value: 25 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'In Progress', value: 'QuotingProposing_InProgress' }
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'ProductionTrialOrder':
            var probabilityOptions = [
                { label: '50% - Quote/Proposal Approved', value: 50 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'In Progress', value: 'ProductionTrialOrder_InProgress' },
                { label: 'Production Trial Failed', value: 'ProductionTrialOrder_ProductionTrialFailed' },
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'AwardEminent':
            var probabilityOptions = [
                { label: '75% - Production Trial Successful', value: 75 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'In Progress', value: 'AwardEminent_InProgress' }
            ];
            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'Closed Won':
            var probabilityOptions = [
                { label: '100% - First Order Received', value: 100 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);
            
            var statusOptions = [
                { label: '', value: '' },
                { label: 'Closed Won - Order Received', value: 'Closed Won_ClosedWonOrderReceived' }
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'Closed Lost':
            var probabilityOptions = [
                { label: '0%', value: 0 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'Price', value: 'Closed Lost_Price' },
                { label: 'Product Performance', value: 'Closed Lost_ProductPerformance' },
                { label: 'Quality', value: 'Closed Lost_Quality' },
                { label: 'Service', value: 'Closed Lost_Service' },
                { label: 'Credit', value: 'Closed Lost_Credit' },
                { label: 'Competition', value: 'Closed Lost_Competition' },
                { label: 'Business Decision', value: 'Closed Lost_BusinessDecision' },
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        case 'ClosedRejected':
            var probabilityOptions = [
                { label: '0%', value: 0 }
            ];

            resetDropdownList(".edit-view-field #probability",probabilityOptions, fieldValues.probability);

            var statusOptions = [
                { label: '', value: '' },
                { label: 'Technical Capabilities', value: 'ClosedRejected_TechnicalCapabilities' },
                { label: 'Operational Capacity', value: 'ClosedRejected_OperationalCapacity' },
                { label: 'Credit Risk', value: 'ClosedRejected_CreditRisk' },
            ];

            resetDropdownList(".edit-view-field #status_c", statusOptions, fieldValues.status);
            break;
        default:
            break;
    }
}

function resetDropdownList(field, options, fieldVal) {
    $(field)
        .find('option')
        .remove()
        .end();
    
    options.map( ( option ) => {
        $(field).append('<option label="'+ option.label +'" value="'+ option.value +'">'+ option.label +'</option>');
    });
    
    fieldVal ? $(field).val(fieldVal) : $(field).val($(field).find('option').first().val());
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

const handleEnableDisableSalesStageChangedFunction = () => {
    if ($('#opportunity_id').val() != '') {
        $.ajax({
            type: "POST",
            url: "index.php?module=Opportunities&action=check_if_tr_exists&to_pdf=1",
            data: { 'opportunity_id': $('#opportunity_id').val()},
            dataType: 'json',
            success: function(jsonResult) {
                const { tr_exists } = jsonResult.data;
                const { success } = jsonResult;
                
                if (success && (! tr_exists)) {
                    $("#sales_stage, #Opportunitiessales_stage").on('change', SalesStageChanged).trigger('change');
                }
            },
            error: function(result){
                console.log(result);
            }
        });
    } else {
        $("#sales_stage, #Opportunitiessales_stage").on('change', SalesStageChanged).trigger('change');
    }
}

const populateSubIndustryDropdown = ({industry, record_id}) => {
    $.ajax({
        type: "GET",
        url: "index.php?module=Opportunities&action=get_sub_industry_dropdown&to_pdf=1",
        data: {
            'industry': industry,
            'opportunity_id':record_id
        },
        dataType: 'json',
        success: function(result) {
            let options = '';
            
            for (const [key, value] of Object.entries(result.dropdown_list)) {
                if (value != null) {
                    options += (key == result.current_value)
                        ? `<option value='${key}' selected>${value}</option>`
                        : `<option value='${key}'>${value}</option>`;

                }
            }

            $('select#sub_industry_c').html(options);

        },
        error: function(result){
            console.log(result);
        }
    });
}

const populateIndustryDropdown = ({sub_industry, record_id}) => {
    
    $.ajax({
        type: "GET",
        url: "index.php?module=Opportunities&action=get_industry_dropdown&to_pdf=1",
        data: {
            'sub_industry': sub_industry,
            'opportunity_id':record_id
        },
        dataType: 'json',
        success: function(result) {
            let options = '';
            
            for (const [key, value] of Object.entries(result.dropdown_list)) {
                if (value != null) {
                    options += (key == result.current_value)
                        ? `<option value='${key}' selected>${value}</option>`
                        : `<option value='${key}'>${value}</option>`;

                }
            }

            $('select#industry_c').html(options);

        },
        error: function(result){
            console.log(result);
        }
    });
}