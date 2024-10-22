var cust_products_otable = null;
var cust_products_page;
var cust_prod_selected_arr = []; 
var record_id = null;

var currentSelectedCustomerProductIds = []; // Array that stores Customer Product ID's on click 'Select' from Pop-up; used as a param in draw dt
var checkedItems = []; // Temp array that stores Customer Product ID's on Check checkbox; used to identify which row to check every datatable draw(). i.e pagination
var isSelectAll = false;

function retrieveFieldsToMap() {
    let requiredFieldsObj = jQuery("div.label:has(span.required)").next("div.edit-view-field");
    let statusVal = jQuery('#status_c').val();
    let fieldsArray = {
        'mandatoryFields': [],
        'nonMandatoryFields': [],
    };    

    var mandatoryFieldNameList = [];

    if(statusVal == 'draft'){
        mandatoryFieldNameList = [];

        if(is_submit_for_review){
            mandatoryFieldNameList = ['req_type_c', 'accounts_rrq_regulatoryrequests_1_name', 'contacts_rrq_regulatoryrequests_1_name', 
            'req_by_c'];
        }
    }
    else if(['new', 'assigned'].includes(statusVal)){
        if(is_submit_for_review){
            mandatoryFieldNameList = ['req_type_c', 'accounts_rrq_regulatoryrequests_1_name', 'contacts_rrq_regulatoryrequests_1_name', 
                'req_by_c'];
        }
        else{
            mandatoryFieldNameList = ['req_type_c', 'assigned_user_name', 'accounts_rrq_regulatoryrequests_1_name', 'contacts_rrq_regulatoryrequests_1_name', 'req_by_c'];
        }
    }
    else{
        mandatoryFieldNameList = ['req_type_c', 'assigned_user_name', 'accounts_rrq_regulatoryrequests_1_name', 'contacts_rrq_regulatoryrequests_1_name'];
    }

    $.each(requiredFieldsObj, function(key, el){
        // Get the field name and push it into the array
        //for (const [key, el] of Object.entries(requiredFieldsObj)) {
        let fieldName = jQuery(el).attr('field');

        if (fieldName != undefined && parseInt(key) >= 0) {
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
    });

    return fieldsArray;
}

function OnStatusChange(){
    
    let { mandatoryFields, nonMandatoryFields } = retrieveFieldsToMap();
    let statusVal = jQuery('#status_c').val();
    
    if(mandatoryFields.length > 0){
        mandatoryFields.forEach( (field) => {
            addToValidate('EditView', field.name, field.type, true, field.label);
        });
    }
    
    if(nonMandatoryFields.length > 0 ){
        $.each(nonMandatoryFields, function(ind, elem){
            removeFromValidate('EditView', elem.name);
        });
    }

    //submit form directly if matches below
    if(is_submit_for_review){
        $('#SAVE').trigger("click");
    }

    retrieveAssignedUser((result) => {
        if (result.success) {
            let {id, full_name} = result.data;
            jQuery("#assigned_user_id").val(id);
            jQuery("#assigned_user_name").val(full_name);
        }
    });
    

    
}

const retrieveAssignedUser = (callback) => {
    jQuery.ajax({
        type: 'GET',
        url: 'index.php?module=RRQ_RegulatoryRequests&action=retrieve_assigned_user&to_pdf=1',
        dataType: 'json',
        data: { 
            regulatory_id: jQuery('input[name="record"]').val(), 
            currentStatus: jQuery('#status_c').val(),
            currentAssignedUserId: jQuery('#assigned_user_id').val()
        }
    }).done(function(response) {
        callback(response);
    });
}

function changeAssignedTo(status){

    //alert(db_status);
    var db_status = $('#db_status').val();
    var db_created_by_name = $('#db_created_by_name').val();
    var db_created_by = $('#db_created_by').val();
    var db_req_by_name = $('#db_req_by_name').val();
    var db_req_by_id = $('#db_req_by_id').val();

    //for common statuses as per requirement in Workflow
    if(status == 'new'){
        if(is_submit_for_review){//disable assigned user
            assigned_user_obj.find('#assigned_user_name_label').show();
            assigned_user_obj.find('input[name="assigned_user_name"]').hide();
            assigned_user_obj.find('button[name="btn_assigned_user_name"]').hide();
            assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').hide();
        }
        else{ //enable assigned user
            assigned_user_obj.find('#assigned_user_name_label').hide();
            assigned_user_obj.find('input[name="assigned_user_name"]').show();
            assigned_user_obj.find('button[name="btn_assigned_user_name"]').show();
            assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').show();
            addToValidate('EditView', 'assigned_user_name', 'varchar', true, 'Assigned to');
        }
    }
    else if(status == 'awaiting_more_info'){
        assigned_user_obj.find('#assigned_user_name_label').show();
        assigned_user_obj.find('input[name="assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').hide();
        $('#assigned_user_id').val($('#db_created_by').val());
        $('#assigned_user_name_label').html($('#db_created_by_name').val());
        removeFromValidate('EditView', 'assigned_user_name');
    }
    else if(status == 'rejected'){
        assigned_user_obj.find('#assigned_user_name_label').show();
        assigned_user_obj.find('input[name="assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').hide();
        $('#assigned_user_id').val($('#db_req_by_id').val());
        $('#assigned_user_name_label').html($('#db_req_by_name').val());
        removeFromValidate('EditView', 'assigned_user_name');
    }
    else if(status == 'created_in_error'){
        assigned_user_obj.find('#assigned_user_name_label').show();
        assigned_user_obj.find('input[name="assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').hide();
        $('#assigned_user_id').val($('#db_created_by').val());
        $('#assigned_user_name_label').html($('#db_created_by_name').val());
        removeFromValidate('EditView', 'assigned_user_name');
    }
    else{
        assigned_user_obj.find('#assigned_user_name_label').hide();
        assigned_user_obj.find('input[name="assigned_user_name"]').show();
        assigned_user_obj.find('button[name="btn_assigned_user_name"]').show();
        assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').show();
        addToValidate('EditView', 'assigned_user_name', 'varchar', true, 'Assigned to');
    }

    if((db_status == 'complete' || db_status == 'rejected')
        && status == 'new'){

        $url = 'index.php?module=RRQ_RegulatoryRequests&action=get_regulatory_manager&to_pdf=1';
        $.post($url, {}).done( (response) => {
            let responseObj = JSON.parse(response);

            if(responseObj.success){
                $('#assigned_user_name').val(responseObj.data.name);
                $('#assigned_user_id').val(responseObj.data.id);
            }

            return data;
        });
    }
    else if(db_status == 'assigned'){
        assigned_user_obj.find('#assigned_user_name_label').show();
        assigned_user_obj.find('input[name="assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').hide();
    }
    else if(db_status == 'in_process'){
        if(status == 'complete'){
            assigned_user_obj.find('#assigned_user_name_label').show();
            assigned_user_obj.find('input[name="assigned_user_name"]').hide();
            assigned_user_obj.find('button[name="btn_assigned_user_name"]').hide();
            assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').hide();

            $('#assigned_user_name_label').html(db_req_by_name);
            $('#assigned_user_id').val(db_req_by_id);
        }
    }
    else if(db_status == 'complete'){
        assigned_user_obj.find('#assigned_user_name_label').show();
        assigned_user_obj.find('input[name="assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_assigned_user_name"]').hide();
        assigned_user_obj.find('button[name="btn_clr_assigned_user_name"]').hide();


        $('#assigned_user_name_label').html(db_created_by_name);
        $('#assigned_user_id').val(db_created_by);
    }
}

const Remove = (e) => {
    var tblLineItems = $('#tbl_customer_products');
    var rowsObj = tblLineItems.find('tbody > tr');
    var rowCount = rowsObj.length;
    let currentRowObj = jQuery(e.target).parents('tr');

    let rowCustomerProductID = currentRowObj.find('input[type=hidden]').val();
    currentSelectedCustomerProductIds = currentSelectedCustomerProductIds.filter(function(idVal) {
        return idVal != rowCustomerProductID;
    }, rowCustomerProductID);
    
    if(rowCount == 1){
        rowsObj.eq(0).find('.customer-product-add').show();

        // if single row is left and input fields has values, only clear input field values instead of removing the entire row
        currentRowObj.find('input').each(function(index) {
            jQuery(this).val(''); // empty row <input> values
        });
        
    } else {
        rowsObj.last().find('.customer-product-add').show();
        $(e.currentTarget).parents('tr').remove();
    }

    manageCustProductButtons();
    if (cust_products_otable != null) {
        cust_products_otable.clear().draw(); // re-draw datatable

    }
}

const clearRow = (row, customerProductRelateBtn, newRowKey) => {
    row.find('.product_num').attr('id', 'product_num_' + newRowKey);
    row.find('.product_num').attr('name', 'product_num_' + newRowKey);
    row.find('.product_version').attr('id', 'product_version_' + newRowKey);
    row.find('.product_version').attr('name', 'product_version_' + newRowKey);
    row.find('.application').attr('id', 'application_' + newRowKey);
    row.find('.application').attr('name', 'application_' + newRowKey);
    row.find('.oem_account').attr('id', 'oem_account_' + newRowKey);
    row.find('.oem_account').attr('name', 'oem_account_' + newRowKey);
    row.find('.industry').attr('id', 'industry_' + newRowKey);
    row.find('.industry').attr('name', 'industry_' + newRowKey);

    
    // Udpdate Clonned Row Key then Clear Name and ID - Assigned To field
    customerProductRelateBtn.parent().find('input:not([type="hidden"])')
        .attr('id', 'customer_product_name_' + newRowKey)
        .attr('name', 'customer_product_name[' + newRowKey + ']')
        .val();

    //customerProductRelateBtn.parent().removeClass('yui-ac').find('div:first').remove();
    
    row.find('input[type="hidden"]')
        .attr('id', 'customer_product_id_' + newRowKey)
        .attr('name', 'customer_product_id[' + newRowKey + ']')
        .val();
}

const manageCustProductButtons = () => {
    let custProductRows = $('#tbl_customer_products > tbody > tr');

    if(custProductRows.length == 1){
        // custProductRows.eq(0).find('.customer-product-remove').hide();
        custProductRows.eq(0).find('.customer-product-add').show();
    }
    else{
        jQuery.each(custProductRows, function(index, custProductRowHTML){
            var currentRowObj = $(custProductRowHTML);
    
            if(custProductRows.length > 1 && index < (custProductRows.length - 1)){
                currentRowObj.find('.customer-product-remove').show();
                currentRowObj.find('.customer-product-add').hide();
            }
            else{
                currentRowObj.find('.customer-product-remove').show();
                currentRowObj.find('.customer-product-add').show();
            }
        });
    }

    //rearrange name and id
    jQuery.each(custProductRows, function(index, custProductRowHTML){
        var currentRowObj = $(custProductRowHTML);

        currentRowObj.find('.product_num').attr('id', 'product_num_' + (index + 1));
        currentRowObj.find('.product_num').attr('name', 'product_num_' + (index + 1));
        currentRowObj.find('.product_version').attr('id', 'product_version_' + (index + 1));
        currentRowObj.find('.product_version').attr('name', 'product_version_' + (index + 1));

        currentRowObj.find('.customer_product_button').parent().find('input:not([type="hidden"])')
            .attr('id', 'customer_product_name_' + (index + 1))
            .attr('name', 'customer_product_name[' + (index + 1) + ']')
            .val();

        currentRowObj.find('.customer_product_button').parent().find('input[type="hidden"]')
            .attr('id', 'customer_product_id_' + (index + 1))
            .attr('name', 'customer_product_id[' + (index + 1) + ']')
            .val();

        currentRowObj.find('.customer_product_button').attr('index', (index + 1)).attr('onclick', 
            'open_popup("CI_CustomerItems", 600, 400, "&from_module=RRQ_RegulatoryRequests", true, false, {"call_back_function":"set_return_customer_product","form_name":' + 
            '"EditView","field_to_name_array":{"id":"customer_product_id_' + (index + 1) + '","name":"customer_product_name_' + (index + 1) + '",'+
            'product_number_c:"product_num_'+ (index + 1) +'",application_c:"application_'+ (index + 1) +'",oem_account_c:"oem_account_'+ (index + 1) +'",industry_c:"industry_'+ (index + 1) +'"}}, "single", true);'
        );
    
        //oem_account_c

        sqs_objects['customer_product_name[' + (index + 1) + ']'] = {
            "form":"EditView",
            "method":"get_user_array",
            "field_list":["user_name","id"],
            "populate_list":['customer_product_name_[' + (index + 1) + ']', 'customer_product_id_[' + (index + 1) + ']'],
            "required_list":['customer_product_id_[' + (index + 1) + ']'],
            "conditions":[{
                "name":"user_name","op":"like_custom","end":"%","value":""
            }],
            "limit":"30","no_match_text":"No Match"
        };
    
        SUGAR.util.doWhen(
            "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['customer_product_name[" + (index + 1) + "]']) != 'undefined'",
            enableQS
        );
    });
}

const onAddCustomerProduct = (e, custProduct) => {
    
    let custProductObj = $('#tbl_customer_products');
    let templateObj = $('#tbl_cust_product_row_template tbody tr:first').clone();

    let clonnedRow = templateObj.clone();
    clonnedRow.find('.customer-product-add').on('click', customer_product_clicked);
    clonnedRow.find('.customer-product-remove').on('click', Remove);
    
    if(custProduct != null){
        if (isSelectAll) {
            // currentSelectedCustomerProductIds = [];
        } else {
            currentSelectedCustomerProductIds.push(custProduct.id);
        }

        clonnedRow.find('.product_num').val(custProduct.product_number_c);
        clonnedRow.find('.product_version').val(custProduct.version_c);
        clonnedRow.find('.customer_product_id').val(custProduct.id);
        clonnedRow.find('.customer_product_name').val(custProduct.name);
        clonnedRow.find('.application').val(custProduct.application_c);
        clonnedRow.find('.oem_account').val(custProduct.oem_account_c);
        clonnedRow.find('.industry').val(custProduct.industry_c);
        
    }
    let customerProductRelateBtn = clonnedRow.find('.customer_product_name').parent().find('button');
    let newRowKey = parseInt($('#tbl_customer_products tbody tr').length) + 1;

    clearRow(clonnedRow, customerProductRelateBtn, newRowKey);

    custProductObj.find('tbody').append(clonnedRow);


    // Modify Popup button onclick action to set selected option on new Assigned To row
    // customerProductRelateBtn.attr('index', newRowKey).attr('onclick', 
    //     'open_popup("CI_CustomerItems", 600, 400, "&from_module=RRQ_RegulatoryRequests", true, false, {"call_back_function":"set_return_customer_product","form_name":' + 
    //     '"EditView","field_to_name_array":{"id":"customer_product_id_' + newRowKey + '","name":"customer_product_name_' + newRowKey + '",' +
    //     'product_number_c:"product_num_'+ newRowKey +'",application_c:"application_'+ newRowKey +'",oem_account_c:"oem_account_'+ newRowKey +'",industry_c:"industry_'+ newRowKey +'"}}, "single", true);'
    // );

    // sqs_objects['customer_product_name[' + newRowKey + ']'] = {
    //     "form":"EditView",
    //     "method":"get_user_array",
    //     "field_list":["user_name","id"],
    //     "populate_list":['customer_product_name_[' + newRowKey + ']', 'customer_product_id_[' + newRowKey + ']'],
    //     "required_list":['customer_product_id_[' + newRowKey + ']'],
    //     "conditions":[{
    //         "name":"user_name","op":"like_custom","end":"%","value":""
    //     }],
    //     "limit":"30","no_match_text":"No Match"
    // };

    // SUGAR.util.doWhen(
    //     "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['customer_product_name[" + newRowKey + "]']) != 'undefined'",
    //     enableQS
    // );

    //alert(clonnedRow.html());
    manageCustProductButtons();
}

const manageCustomerProducts = () => {
    var custProductsData = $('#tbl_customer_products').attr('data-rows');
    var custProductsDataObj = JSON.parse(custProductsData);
    if(custProductsData.length > 2){ //means it has an ID
        jQuery.each(custProductsDataObj, function(index, custProduct){
            onAddCustomerProduct(null, custProduct);
        });
    } else { 
        onAddCustomerProduct();
    }
}

const isValidAllRows = () => {
    let result = true;
    
    $('#tbl_customer_products > tbody > tr').each(function(idx, row){
        var trRowObj = $(row);
        prodNumVal = trRowObj.find('.product_num').val();
        
        if(prodNumVal == ''){
            result = false;
        }
    });
    
    return result;
}

const SaveForm = () => {
    $('#SAVE.button.primary, #save_and_continue.button')
    .removeAttr('onclick')
    .on('click', (event) => {
        event.preventDefault();

        let buttonEvent = event;
        let _form = document.getElementById('EditView');
        _form.action.value = 'Save';
        let isValid = isValidAllRows(); // Checks if Customer Products have been added
        
        //debugger;
        // if(is_submit_for_review && !isValidAllRows()){
        //     isValid = false;
        //     alert('Please recheck or add atleast one Customer Product(s)');
        // }
        
        if (check_form('EditView')) {
            if (isValid == 0) {
                alert('Please recheck or add atleast one Customer Product(s)');
                jQuery('div[field=custom_customer_products_html]').addClass('cstm-error-block');
            } else {
                jQuery('div[field=custom_customer_products_html]').removeClass('cstm-error-block');
                SUGAR.ajaxUI.submitForm(_form); // this will submit the form
            }
        } 

    });

    $('#SubmitForReview')
    .removeAttr('onclick')
    .on('click', (event) => {
        event.preventDefault();

        is_submit_for_review = true;
        $('#status_c').val('new').trigger('change');

        let buttonEvent = event;
        let _form = document.getElementById('EditView');
        _form.action.value = 'Save';
        let isValid = check_form('EditView');

        //debugger;
        
        if(!isValidAllRows()){
            isValid = false;
            jQuery('div[field=custom_customer_products_html]').addClass('cstm-error-block');
            alert('Please recheck or add atleast one Customer Product(s)');
        }

        if(isValid){
            $('#custom_action').val('SubmitForReview');
            jQuery('div[field=custom_customer_products_html]').removeClass('cstm-error-block');
            SUGAR.ajaxUI.submitForm(_form);
        }
        else{
            console.log('form not yet valid');
        }
    });
}

const set_industry = (industry_val) => {
    let result = '';
    let industry_dom_obj = JSON.parse(industry_dom);

    $.each(industry_dom_obj, function(index, item){
        if(index === industry_val){
            result = item;
        }
    });

    return result;
}

function set_return_customer_product(popup_reply_data){

    if(popup_reply_data != null){
        var name_val_arr = popup_reply_data.name_to_value_array;

        for (let [key, value] of Object.entries(name_val_arr)) {
            if(key.startsWith('industry_')){
                $('#' + key).val(set_industry(value));
            }
            else{
                $('#' + key).val(value);
            }
        }
    }
}


const get_order_column = (index) => {
    let result = '';

    if(index == 1){
        result = 'product_number_c';
    }
    else if(index == 2){
        result = 'name';
    }
    else if(index == 3){
        result = 'application_c';
    }
    else if(index == 4){
        result = 'oem_account_c';
    }
    else if(index == 5){
        result = 'industry_c';
    }

    return result;
};


const customer_product_clicked = (e) => {
    // $('#accountName').val('');
    $('#productNum').val('');
    $('#productName').val('');
    $('#custProdNum').val('');
    
    cust_products_otable.clear().draw(); //clear all rows
    $('#mdl-customer-product').modal('toggle');
}

const cust_prod_select_clicked = (e) => {
    var is_cust_prod_exist = false;
    
    for(var cpKey in cust_prod_selected_arr){
        var cust_prod_item = JSON.parse(cust_prod_selected_arr[cpKey]);
        var cust_prod_row_list = $('#tbl_customer_products > tbody > tr');
        
        // Removed condition as figured out a way to push data to array for filtering purposes without passing array to AJAX if isSelectAll is true
        // if (!isSelectAll) {
            // Push items to array only when event is not from SELECT ALL Button to avoid sending
            // large amount of data to draw() function
            currentSelectedCustomerProductIds.push(cust_prod_item[0]); 
        // }
        
        var first_cust_prod_row = cust_prod_row_list.eq(0);
        var cust_prod_id = first_cust_prod_row.find('.customer_product_id').val();
        if(cust_prod_id == null || cust_prod_id == ''  || cust_prod_id == undefined ){
            first_cust_prod_row.remove();
        }

        is_cust_prod_exist = false;
        cust_prod_row_list.each(function(idx, cust_prod_row){
            var cust_prod_row_obj = $(cust_prod_row);
            var cust_prod_id = cust_prod_row_obj.find('.customer_product_id').val();

            //remove empty Customer Product row
            if(cust_prod_id == null || cust_prod_id == ''){
                first_cust_prod_row.remove();
            }

            //append selected Customer Product
            if(cust_prod_id == cust_prod_item[0]){
                is_cust_prod_exist = true;
            }
        });

        if(!is_cust_prod_exist){
            var cust_prod = {
                'id': cust_prod_item[0],
                'product_number_c': cust_prod_item[2],
                'name': cust_prod_item[1],
                'application_c': cust_prod_item[3],
                'oem_account_c': cust_prod_item[4],
                'industry_c': cust_prod_item[5],
            };

            onAddCustomerProduct(null, cust_prod);
        }
    }

    // console.log(cust_prod_selected_arr)

    $('#mdl-customer-product').modal('hide');
    
    cust_products_otable.clear().draw(); // re-draw datatable
    cust_prod_selected_arr = [];
}

const cust_prod_checked = (e) =>{
    var chkBox = jQuery(e.currentTarget);
    
    if(chkBox.is(':checked')){
        checkedItems.push(chkBox.val());
        cust_prod_selected_arr[cust_prod_selected_arr.length] = chkBox.attr('data-row');
    } else {
        checkedItems = checkedItems.filter(customer_product_id => customer_product_id != chkBox.val());
        for(var cpKey in cust_prod_selected_arr){
            var cust_prod_item = JSON.parse(cust_prod_selected_arr[cpKey]);
            if(cust_prod_item[0] == chkBox.val()){
                cust_prod_selected_arr.splice(cpKey, 1);
            }
        }
    }
}

/**
 * 
 * @param {event} e 
 * Handles the Product Name link click event: ticks the checkbox and closed the pop-up 
 * @author: Glai Obido
 */
const customProductNameClick = (e) => {
    let rowCheckboxObj = jQuery(e.target).parents('tr').find('input[type=checkbox]');
    rowCheckboxObj.prop('checked', true).trigger('change'); // tick the checkbox and trigger cust_prod_checked function
    $('#cust_prod_select').trigger("click"); // trigger click event to call cust_prod_select_clicked function
    

}

const customerProductSelectAllPageRows = (e) => {
    
    if (e.target.checked) {
        jQuery('.dt-checkboxes').prop('checked', true).trigger('change');

    } else {
        jQuery('.dt-checkboxes').prop('checked', false).trigger('change');
    }

}

const selectAllCustomerProducts = (e) => {
    
    isSelectAll = e.target.checked; // boolean
    
    if (e.target.checked) {
        jQuery('.dt-checkboxes, #dt-checkbox-select-all-rows').prop('checked', true).prop('disabled', true);
        
        drawDataOnly((result) => {
            let { aaData } = result;
            let labelText = `Deselect All (${aaData.length})`;

            aaData.forEach(element => {
                let stringified = JSON.stringify(element);
                cust_prod_selected_arr.push(stringified);
            });

            jQuery(e.target).parent().find('span').text(labelText)
    
        });

    } else {
        // console.log(currentSelectedCustomerProductIds)
        cust_prod_selected_arr = [];
        jQuery('.dt-checkboxes, #dt-checkbox-select-all-rows').prop('checked', false).prop('disabled', false);
        jQuery(e.target).parent().find('span').text('Select All')
    }

}

const drawDataOnly = (callback) => {
        
    let data = {
        'iDisplayLength': -1,
        'sSortDir_0': 'asc',
        'searchProductNum':jQuery('#productNum').val(),
        'accountID': jQuery('#accounts_rrq_regulatoryrequests_1accounts_ida').val(),
        'accountName':  jQuery('#accounts_rrq_regulatoryrequests_1_name').val(),
        'searchProductName': jQuery('#productName').val(),
        'searchCustProdNum': jQuery('#custProdNum').val(),
        'rqId': record_id,
    };

    if (! isSelectAll) {
        data.currentSelectedCustomerProductIds = JSON.stringify(currentSelectedCustomerProductIds); // array of currently checked id's from Add More Pop-up
    }

    jQuery.ajax({
        type: 'GET',
        url: 'index.php?module=RRQ_RegulatoryRequests&action=get_customer_products&to_pdf=1',
        dataType: 'json',
        data : data
    }).done(function(response) {
        callback(response);
    });
};


const set_customer_products_dt = () => {
    var url = 'index.php?module=RRQ_RegulatoryRequests&action=get_customer_products&to_pdf=1';

    if(cust_products_otable == null){
        cust_products_otable = $('#tbl-customer-products').DataTable( {
            "bFilter": false,
            "bLengthChange": false,
            "pagingType": "full_numbers",
            "pageLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "sScrollY": "400px",
            "sScrollX": "20%",
            "fnServerParams": function (aoData) {
                
                var accountName = jQuery('#accounts_rrq_regulatoryrequests_1_name').val();
                var accountID = jQuery('#accounts_rrq_regulatoryrequests_1accounts_ida').val();
                
                
                aoData.push( { "name": "accountID", "value": accountID } );
                aoData.push( { "name": "accountName", "value": accountName } );

                aoData.push( { "name": "searchAccountName", "value": jQuery('#accountName').val() } );
                aoData.push( { "name": "searchProductNum", "value": jQuery('#productNum').val() } );
                aoData.push( { "name": "searchProductName", "value": jQuery('#productName').val() } );
                aoData.push( { "name": "searchCustProdNum", "value": jQuery('#custProdNum').val() } );
                aoData.push( { "name": "rqId", "value": record_id } );
                
                if (! isSelectAll) {
                    aoData.push( { "name": "currentSelectedCustomerProductIds", "value": JSON.stringify(currentSelectedCustomerProductIds) } ); // array of currently checked id's from Add More Pop-up
                }
            },
            //HTTP_TYPE: "POST",
            // serverSide:     true,
            // ajaxUrl:           url,
            // pipeline:          true,  //Use dataTables pipeline ajax function for caching.
            // pagesToCache: 5, //Number of pages to cache
            columnDefs: [ 
                {
                    orderable: false,
                    //className: 'select-checkbox',
                    targets:   0,
                    'render': function(data, type, row, meta) {
                        data = "<input type='checkbox' class='dt-checkboxes' value='"+ data +"' data-row='"+ JSON.stringify(row) +"'>";
                        return data;
                    },
                },

                {
                    targets:   3,
                    'render': function(data, type, row, meta) {
                        // row[0] is the product id value
                        data = (data != null) ? "<a class='product-name-btn' href='javascript:void(0)' data-id='"+ row[0] +"'>"+ data +"</a>" : data;
                        return data;
                    },
                }
            ],
            //order: [[ 1, 'asc' ]],
            "preDrawCallback": function (settings) {
                
                return true;
            },
            drawCallback: function(settings){
                jQuery('#dt-checkbox-select-all-rows').off('change'); // Fix on triggering the event twice   
                jQuery('#select-all-data').off('change'); // Fix on triggering the event twice   
                
                jQuery('.dt-checkboxes').on("change", cust_prod_checked);
                jQuery('#dt-checkbox-select-all-rows').on("change", customerProductSelectAllPageRows);
                jQuery('#select-all-data').on("change", selectAllCustomerProducts);
                jQuery('.product-name-btn').on("click", customProductNameClick);

                let dataTableReturnData = cust_products_otable.ajax.json(); // object
                
                if (dataTableReturnData?.accountNameString) {
                    jQuery('#accountName').val(dataTableReturnData.accountNameString);
                }
                
                if (dataTableReturnData.accountNameString.length > 0) {
                    jQuery('#accountName').addClass('custom-readonly');
                } else {
                    jQuery('#accountName').removeClass('custom-readonly');
                }
                
                if (isSelectAll) {
                    // check all checkboxes of current page
                    jQuery('.dt-checkboxes, #dt-checkbox-select-all-rows')
                        .prop('checked', true)
                        .prop('disabled', true);
                }

                // Feature to retain ticked checkboxes on next/prev page
                cust_products_otable.rows().every( function () {
                    let node = this.node();
                    let checkboxCell = node.cells[0];
                    let cellRecordId = checkboxCell.firstChild.defaultValue;
                    
                    if (checkedItems.includes(cellRecordId)) {
                        jQuery(`input.dt-checkboxes[value='${cellRecordId}']`).prop('checked', true);
                    }
                });
            }
        });

        jQuery('#cust_prod_select').on("click", cust_prod_select_clicked);

        jQuery('#cust_prod_select, #cust_prod_close').on("click", () => {
            // Uncheck Select From Current Page AND manually ticked checkboxes on SELECT or CLOSE
            jQuery('.dt-checkboxes, #dt-checkbox-select-all-rows')
                .prop('checked', false)
                .trigger('change');

            // Trigger Deselect All on SELECT or CLOSE
            jQuery("input[id='select-all-data']:checked").trigger('click');
        });

        // On next page, uncheck Select From Current Page but maintain checked rows from previous page
        jQuery('#tbl-customer-products').on('page.dt', () => {
            // Note: Do not trigger change as it empties the array containing the checked rows
            jQuery('#dt-checkbox-select-all-rows')
                .prop('checked', false);
        });
    }
}

const search_customer_products_clicked = (e) => {
    cust_products_otable.search('').draw();
}

const triggerFilterStatusOptions = () => {
    
    let statusValue = jQuery("select#status_c").val();
    let recordId = jQuery('form#EditView input[name="record"]').val();
    let isSubmitToDraft = is_submit_for_review || 'false';

    
    $.ajax({
        url: `index.php?module=RRQ_RegulatoryRequests&action=status_filtered&submit_for_review=${isSubmitToDraft}&to_pdf=1`,
        type: "GET",
        data: { 'status': statusValue, 'record_id': recordId },
        success: function(result){
            jQuery('#status_c').html(result);
        },
        error: function(response) {
            console.log("error: ", response)
        } 
    });
}



$(document).ready(function(e){
    var recordVal = $('input[name="record"]').val();
    record_id = $('input[name="record"]').val();
    triggerFilterStatusOptions();
    $('#status_c').on("change", OnStatusChange);

    SaveForm();

    setTimeout(function(){
        $('#status_c').trigger('change'); 
    }, 500)

    if(recordVal == '' || recordVal == null){
        onAddCustomerProduct();
    }
    else{
        manageCustomerProducts();
    }
    
    set_customer_products_dt(); // Initialize datatable object
    // jQuery('#btn-add-customer-product').on("click", customer_product_clicked);

    jQuery('#searchCustomerProducts').on("click", search_customer_products_clicked);
});
