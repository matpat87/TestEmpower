$(document).ready(function(){
  var beanId = $('form#EditView').find('input[name="record"]').val();
  var submitDraft = $('#submit_draft').val();
  
 
  if (! beanId) {
    $('#update_text').closest('.edit-view-row-item').hide();
    $('#update_text_label').closest('.edit-view-row-item').hide();
    $('#internal').closest('.edit-view-row-item').hide();
    $('#internal_label').closest('.edit-view-row-item').hide();
    $('#addFileButton').closest('.edit-view-row-item').hide();
    $('#case_update_form_label').closest('.edit-view-row-item').hide();
    // tinyMCE.execCommand('mceAddControl', false, document.getElementById('description'));

    $("select[name='site_c']").on('change',function(event) {
        event.preventDefault();
        var selectedSite = $(this).val();

        $.ajax({
            url: "index.php?entryPoint=retrieveCaseSiteLabManagers&to_pdf=1",
            data: {
                selectedSite: selectedSite
            },
            success: function(result){
                var jsonResult = JSON.parse(result);

                if(jsonResult) {
                    $("#users_cases_1_name").val(jsonResult.first_name + ' ' + jsonResult.last_name);
                    $("#users_cases_1users_ida").val(jsonResult.id);
                } else {
                    $("#users_cases_1_name").val('');
                    $("#users_cases_1users_ida").val('');
                }
            }
        });
    });

    handleTabHide();

  }
  
    SaveForm(beanId);
    intervalChecker();
    // handleAccountIdChanged();
    // handleCustomerProductChanged();
    handleClosedStatusChange();
    handleCloseStatusOption(beanId);
    handleCustomMandatoryFields(); // on status change event
    sourcesMandatoryField();

    if (submitDraft == 'true') {
        // trigger the submit event to highlight mandatory fields
        $('#SAVE.button.primary').first().trigger('click');
    }

    triggerFilterStatusOptions(); // Filter options according to selected value
    handleSiteChange();
    handleEnableDisableSiteField();
});

function SaveForm(beanId)
{
    $('#SAVE.button.primary')
        .removeAttr('onclick')
        .on('click', (event) => {
            event.preventDefault();
            
            let statusValue = $("select#status").val();

            if (statusValue == 'CAPAComplete') {
                triggerPreventiveActionCheck(beanId)
            } else {
                let _form = document.getElementById('EditView');
                _form.action.value = 'Save';
                check_form('EditView') && SUGAR.ajaxUI.submitForm(_form);

            }

            // RemoveAllValidations();
            TriggerTabChecking();
        });
}

function intervalChecker() {
    var created_date = $("#create_date_c").val();

    setInterval(() => {
        var isCreateDateChanged = checkMarketRelateFieldChanges(created_date);

        if (isCreateDateChanged) {
            var  created_date_obj = new Date(created_date);
            created_date_obj.setDate(created_date_obj.getDate() + 11);

            var due_date_str = created_date_obj.getMonth() + 1 + '/' + created_date_obj.getDate() + '/' + created_date_obj.getFullYear()
            $('#due_date_c').val(due_date_str)
        }
    }, 200);
};

function checkMarketRelateFieldChanges(created_date) {
    return (created_date !== $("#create_date_c").val()) ? true : false;
};

const handleAccountIdChanged = () => {
    let account_id_prev = $("#account_id").val();
    // handleProductNumberAutocomplete(account_id_prev);
    // handleInvoiceNumberAutocomplete();
    
    setInterval(() => {
        let account_id_new = $("#account_id").val();
        let account_name = $("#account_name").val();
        
        if (account_name.length === 0) {
            $("#account_id").val('');
        }

        if (account_id_prev != account_id_new) {
            let popupBtn = $("#btn_ci_customeritems_cases_1_name");
            let popupBtnOnClickEvent = popupBtn.attr('onclick');

            let invoicePopupBtn = $("#btn_aos_invoices_cases_1_name");
            let invoicePopupBtnOnClickEvent = invoicePopupBtn.attr('onclick');
    
            popupBtnOnClickEvent = popupBtnOnClickEvent.replace(`&account_id=${account_id_prev}`, `&account_id=${account_id_new}`);
            popupBtn.attr('onclick', popupBtnOnClickEvent);

            invoicePopupBtnOnClickEvent = invoicePopupBtnOnClickEvent.replace(`&account_id=${account_id_prev}`, `&account_id=${account_id_new}`);
            invoicePopupBtn.attr('onclick', invoicePopupBtnOnClickEvent);

            account_id_prev = account_id_new;

            // handleProductNumberAutocomplete(account_id_prev);
            // handleInvoiceNumberAutocomplete();

            jQuery("#ci_customeritems_cases_1_name").val('');
            jQuery("#ci_customeritems_cases_1ci_customeritems_ida[type=hidden]").val('');
            
            jQuery("#aos_invoices_cases_1_name").val('');
            jQuery("#aos_invoices_cases_1aos_invoices_ida[type=hidden]").val('');
        }
    }, 500)
}

const handleCustomerProductChanged = () => {
    let prevId = $("#ci_customeritems_cases_1ci_customeritems_ida").val();
    let prevName = $("#ci_customeritems_cases_1_name").val();
    handleInvoiceNumberAutocomplete();
    
    setInterval( () => {
        let newId = jQuery("#ci_customeritems_cases_1ci_customeritems_ida").val();
        let customerProductName = jQuery("#ci_customeritems_cases_1_name").val();
        
        
        if (customerProductName.length === 0) {
            $("#ci_customeritems_cases_1ci_customeritems_ida").val('');
        }
        
        
        if (prevId != newId) {
            let invoicePopupBtn = $("#btn_aos_invoices_cases_1_name");
            let invoicePopupBtnOnClickEvent = invoicePopupBtn.attr('onclick');

            invoicePopupBtnOnClickEvent = invoicePopupBtnOnClickEvent.replace(`&customer_product_id=${prevId}`, `&customer_product_id=${newId}`);
            invoicePopupBtn.attr('onclick', invoicePopupBtnOnClickEvent);
            prevId = newId;
            handleInvoiceNumberAutocomplete();

            jQuery("#aos_invoices_cases_1_name").val('');
            jQuery("#aos_invoices_cases_1aos_invoices_ida[type=hidden]").val('');
        }

        //OnTrack #1457
        if(prevName != customerProductName){
            prevName = customerProductName;

            $.ajax({
                url: "index.php?module=Cases&action=get_cp_id&to_pdf=1",
                type: "POST",
                data: { 'product_name': customerProductName },
                success: function(result){
                    let dataObj = JSON.parse(result);
                    if (dataObj.status) {
                        $('#ci_customeritems_cases_1ci_customeritems_ida').val(dataObj.data);
                    } else {
                        $('#ci_customeritems_cases_1ci_customeritems_ida').val('');
                    }
                },
                error: function(response) {
                    console.log("error: ", response)
                } 
            }); 
        }
    }, 500);
}

const handleProductNumberAutocomplete = (accountId) => {
    accountId = accountId.length > 0 ? accountId : "NULL";

    sqs_objects['EditView_ci_customeritems_cases_1_name']['conditions'][1] = {
        name: "ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida",
        op: "equal",
        value: accountId
    };
    
    sqs_objects['EditView_ci_customeritems_cases_1_name']['group'] = 'and';

    SUGAR.util.doWhen(
        "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['EditView_ci_customeritems_cases_1_name']) != 'undefined'",
        enableQS
    );
}

const handleInvoiceNumberAutocomplete = () => {
    let accountId = $("#account_id").val().length > 0 
        ? $("#account_id").val()
        : "NULL";

    let customerProductId = $("#ci_customeritems_cases_1ci_customeritems_ida").val().length > 0 
        ? $("#ci_customeritems_cases_1ci_customeritems_ida").val()
        : "NULL";

    sqs_objects['EditView_aos_invoices_cases_1_name']['conditions'][1] = {
        name: "aos_products_quotes.item_number_c",
        op: "equal",
        value: customerProductId
    };
    sqs_objects['EditView_aos_invoices_cases_1_name']['conditions'][2] = {
        name: "aos_invoices.billing_account_id",
        op: "equal",
        value: accountId
    };
    
    sqs_objects['EditView_aos_invoices_cases_1_name']['group'] = 'and';

    SUGAR.util.doWhen(
        "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['EditView_ci_customeritems_cases_1_name']) != 'undefined' && typeof(sqs_objects['EditView_aos_invoices_cases_1_name']) != 'undefined'",
        enableQS
    );
}

function customValidateProductAmount(label, fieldname)
{
    min = 0;
    max = 999999999;
    formname = 'EditView';

    // addToValidate(formname, fieldname, 'integer', true, label);
    validate[formname][validate[formname].length-1][jstypeIndex] = 'range';
    validate[formname][validate[formname].length-1][minIndex] = min;
    validate[formname][validate[formname].length-1][maxIndex] = max;
}

function handleClosedStatusChange() {
    var currentClosedDate = $("input#close_date_c").val();
    jQuery("select#status").on("change", function() {
        var newStatusID = $(this).val(),
            newStatusText = $(this).children('option:selected').text();
            
        // Fill date now on Status Change to "Closed"
        if (newStatusText.indexOf("Closed") > 1) {
            var now = new Date();
            console.log(newStatusText)
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = (month) + "/" + (day) + "/"+ now.getFullYear();
            var dateClosed = currentClosedDate && currentClosedDate != '' ? currentClosedDate : today;
            $('#datePicker').val(dateClosed);
            $("input#close_date_c").val(dateClosed);

        } else {
            $("input#close_date_c").val(null);
        }
       
    });
}

function handleCloseStatusOption(beanId) {
    
    $.ajax({
        url: "index.php?module=Cases&action=check_related_preventive_actions&to_pdf=1",
        type: "POST",
        data: { 'customer_issue_id': beanId },
        success: function(result){
            let dataObj = JSON.parse(result);
            if (dataObj.success && dataObj.can_close) {
                // Enable Closed status in dropdown list
                $("select#status option[value=Closed]").removeAttr("disabled").css("color", 'inherit');
            } else {
                // Disable Closed status in dropdown list
                $("select#status option[value=Closed]").attr("disabled", "disabled").css("color", "#a9abaa");
            }
        },
        error: function(response) {
            console.log("error: ", response)
        } 
    }); 
}

function handleCustomMandatoryFields() {
    
    $("select#status").on('change', function() {
        var statusValue = $(this).val(),
            statusFilters = ['Approved', 'InProcess', 'CAPAReview', 'CAPAApproved', 'CAPAComplete', 'Closed'],
            customRequiredFields = [
                { name: 'ci_type_c', type: 'enum', label:'Type' },
                { name: 'ci_department_c', type: 'enum', label:'Department' },
                { name: 'due_date_c', type: 'date', label:'Due Date' },
                { name: 'priority', type: 'enum', label:'Severity' },
                { name: 'type', type: 'enum', label:'Category' }
            ];
            

        // if selected statusValue is in the statusFilters array, make fields (type, department, due_date, severity, category) mandatory
        if (statusFilters.includes(statusValue)) {
            $.each(customRequiredFields, function(index, field) {
                addToValidate('EditView', field.name, field.type, true, field.label);

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel).append('<span class="required">*</span>');
                
                if (field.name == 'due_date_c' && $(`#${field.name}`).val() == '') {
                    setDefaultDueDate();
                }
            });
        } else {
            $.each(customRequiredFields, function(index, field) {
                // console.log(jQuery(document).find('.tab-pane-NOBOOTSTRAPTOGGLER .custom-validation-red'));
                removeFromValidate('EditView', field.name);

                let divField = $(`div[field='${field.name}']`).prev();
                let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
                divField.text(divFieldNewLabel);

                $(`#${field.name}`).removeAttr('style')
                    .parent().find('.required.validation-message')
                    .css('display', 'none');
                
            });
        }

        // On Status == Draft, remove all required validations
        draftMandatoryFields(statusValue)
        handleTabHide();
        

    }).trigger('change');
}

function TriggerTabChecking() {

    $('.tab-pane-NOBOOTSTRAPTOGGLER').each(function(index, item){
        var tab_pane = $(item);

        var validationMessagesObj= tab_pane.find('.validation-message:not([style*="display: none"])');
        
        var tab_pane_id = tab_pane.attr('id');
        var tab_pane_index = tab_pane_id.substring(12); //count from tab pane id: tab-content-
        var nav_tab = $('#EditView_tabs .nav-tabs > li').eq(tab_pane_index);

        if(validationMessagesObj != null && validationMessagesObj.length > 0)
        {
            nav_tab.find('a').addClass('text-red-important');
            nav_tab.find('a').addClass('custom-validation-red');

        } else {
            nav_tab.find('a').removeClass('text-red-important');
            nav_tab.find('a').removeClass('custom-validation-red');

        }
    });
}

function setDefaultDueDate() {
    var now = new Date();
    now.setDate(now.getDate() + 14);

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var due_date = (month) + "/" + (day) + "/"+ now.getFullYear();
    $("#due_date_c").val(due_date); 
}

const getAllRequiredFields = () => {
    let requiredFieldsObj = jQuery("div.label:has(span.required)").next("div.edit-view-field");
    let requiredFieldNames = [];

    // Get the field name and push it into the array
    for (const [key, el] of Object.entries(requiredFieldsObj)) {
        let fieldName = jQuery(el).attr('field')
        if (fieldName != undefined && parseInt(key) >= 0 && fieldName != 'name') {
            
            let returnObj = {};
            returnObj['name'] = fieldName;
            returnObj['type'] = jQuery(el).attr('type');
            returnObj['label'] = jQuery(el).prev().text().trim().split(":")[0];
            returnObj['field'] = jQuery(el);
            returnObj['field_asterisk'] = jQuery(el).prev().find('span.required');
            requiredFieldNames.push(returnObj)
        }
    }
    return requiredFieldNames;
}

const draftMandatoryFields = (statusValue) => {
    let requiredFields = getAllRequiredFields();
    let _form = document.getElementById('EditView');
    let draftModeStatus = ['Draft', 'CreatedInError'];
    let sourceValue = jQuery('#source_c').val();
    let sourceCustomMandatory = ['ExternalAudit', 'InternalAudit'];
    let customRequiredFields = ['potential_claim_c', 'potential_return_c'];
    let forRootCauseStatuses = ['InProcess', 'CAPAReview', 'CAPAApproved', 'CAPAComplete', 'Closed'];

    requiredFields.forEach(field => {
        if (draftModeStatus.includes(statusValue)) {
            removeFromValidate('EditView', field.name);
            
            let idString = "#" + field.name;

            jQuery(field['field']).children(idString).removeAttr('style');
            jQuery(field['field']).children(idString).siblings('.validation-message').css('display', 'none');
            // jQuery(field['field_asterisk']).css('visibility', 'hidden');
            TriggerTabChecking();
            return;
            
        } else if (sourceCustomMandatory.includes(sourceValue) && customRequiredFields.includes(field.name)) {
            
            removeFromValidate('EditView', field.name);
            
            let idString = "#" + field.name;

            jQuery(field['field']).children(idString).removeAttr('style');
            jQuery(field['field']).children(idString).siblings('.validation-message').css('display', 'none');
            jQuery(field['field_asterisk']).css('visibility', 'hidden');
            TriggerTabChecking();
            return;

        } else {

            addToValidate('EditView', field.name, field.type, true, field.label);
            // customValidateProductAmount($("div[data-label='LBL_PRODUCT_AMOUNT_LBS'").html().trim().replace(/:/g, ''), 'product_amount_lbs_c');
            jQuery(field['field_asterisk']).css('visibility', 'visible');
            TriggerTabChecking();
            return;
        }
        
    });
    
    //OnTrack #1402 - Root Cause Type Mandatory
    if(forRootCauseStatuses.includes(statusValue)){
        var label = $('div[data-label="LBL_ROOT_CAUSE_TYPE"]').text().split(":")[0];
        addToValidate('EditView', 'root_cause_type_c', 'enum', true, label);
        TriggerTabChecking();
    }
    else{
        removeFromValidate('EditView', 'root_cause_type_c');
        var field = $('div[field="root_cause_type_c"]');
        jQuery(field).children('#root_cause_type_c').removeAttr('style');
        jQuery(field).children('#root_cause_type_c').siblings('.validation-message').css('display', 'none');
        jQuery(field.prev().find('span.required')).css('visibility', 'hidden');
        TriggerTabChecking();
    }
}

const sourcesMandatoryField = () => {
    jQuery('select#source_c').on('change', function() {
        let statusValue = jQuery("#status").val();
        draftMandatoryFields(statusValue);
    }).trigger('change');
}

const triggerPreventiveActionCheck = (beanId) => {
   
    $.ajax({
        url: "index.php?module=Cases&action=check_closed_related_preventive_actions&to_pdf=1",
        type: "POST",
        data: { 'customer_issue_id': beanId },
        success: function(result){
            let dataObj = JSON.parse(result);
            
            if (dataObj.success && dataObj.all_closed) {
                let _form = document.getElementById('EditView');
                _form.action.value = 'Save';
                check_form('EditView') && SUGAR.ajaxUI.submitForm(_form);
            } else {
                alert('Unable to set Status to CAPA Complete: Issue has still unclosed Preventive Action(s)');
            }
        },
        error: function(response) {
            console.log("error: ", response)
        } 
    }); 
}

const triggerFilterStatusOptions = () => {
    
    let statusValue = jQuery("select#status").val();
    let recordId = jQuery('form#EditView input[name="record"]').val();
    let isSubmitToDraft = $('#submit_draft').val();
    
    $.ajax({
        url: `index.php?module=Cases&action=status_filtered&submit_draft=${isSubmitToDraft}&to_pdf=1`,
        type: "GET",
        data: { 'status': statusValue, 'record_id': recordId },
        success: function(result){
            jQuery('#status').html(result);
        },
        error: function(response) {
            console.log("error: ", response)
        } 
    });
}

const handleTabHide = () => {
    let statusValue = jQuery("#status").val();
    let isSubmitToDraft = $('#submit_draft').val();
    
    if (statusValue == 'Draft' || isSubmitToDraft == "true") {
        // hide TABS except Issue Tab
        jQuery("#EditView_tabs .nav-tabs > li:not('.active')").addClass('hidden');
    } else {
        jQuery("#EditView_tabs .nav-tabs > li:not('.active')").removeClass('hidden');
    }
}

const handleEnableDisableSiteField = () => {
    let isSubmitIssue = jQuery('#submit_draft').val();

    jQuery("select#status").on("change", function () {
        let self = jQuery(this);

        (self.val() == 'Draft' || isSubmitIssue == "true")
            ? jQuery('#site_c').removeClass('custom-readonly')
            : jQuery('#site_c').addClass('custom-readonly');
    }).trigger('change');
}

const handleSiteChange = () => {
    const currentSiteVal = jQuery('#site_c').val();
    const currentReturnAuthorizationByVal = jQuery('#return_authorization_number_c').val();

    jQuery('#site_c').on('change', function() {
        let self = jQuery(this);
        let siteVal = self.val();
        let recordId = jQuery('form#EditView input[name="record"]').val();
        let returnAuthorizationBy = jQuery('#return_authorization_number_c');

        jQuery.ajax({
            url: `index.php?module=Cases&action=filter_return_authorization_by&to_pdf=1`,
            type: "GET",
            data: { 'site': siteVal, 'record_id': recordId, 'return_authorization_by': returnAuthorizationBy.val() },
            success: function(result){
                returnAuthorizationBy.html(result);

                (currentSiteVal !== siteVal)
                    ? returnAuthorizationBy.val('')
                    : returnAuthorizationBy.val(currentReturnAuthorizationByVal);
            },
            error: function(response) {
                console.log("error: ", response)
            }
        });
    }).trigger('change');
}