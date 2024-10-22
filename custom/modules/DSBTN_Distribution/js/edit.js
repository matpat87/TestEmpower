var isAllowSubmit = false;
var onPageLoad = true;
var site_colormatch_coordinator_id = $("#site_colormatch_coordinator_id").val();
var site_colormatch_coordinator_name = $("#site_colormatch_coordinator_name").val();
var addresses = [];

$(document).ready(function(e){
    
    ManageTechnicalRequest();
    Initialize();
    
    $(".distro_item_assigned_user_name_button").each( (index, val) => {
        $(val).attr(
            'onclick', 
            'open_popup("Users", 600, 400, "", true, false, {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"distro_item_assigned_user_id_' + index + '","user_name":"distro_item_assigned_user_name_' + index + '"}}, "single", true);'
        );

        sqs_objects['distro_item_assigned_user_name[' + index + ']'] = {
            "form":"EditView",
            "method":"get_user_array",
            "field_list":["user_name","id"],
            "populate_list":['distro_item_assigned_user_name[' + index + ']', 'distro_item_assigned_user_id[' + index + ']'],
            "required_list":['distro_item_assigned_user_id[' + index + ']'],
            "conditions":[{
                "name":"user_name","op":"like_custom","end":"%","value":""
            }],
            "limit":"30","no_match_text":"No Match"
        };
    });
    
    $('.distribution-add').on('click', AddDistributionItem);

    $('.distribution-remove').on('click', Remove);

    $("#SAVE.button.primary").removeAttr('accesskey');
    $("#SAVE.button.primary").removeAttr('onclick');
    $("#SAVE.button.primary").removeAttr('type');
    $("#SAVE.button.primary").attr('type', 'button');

    $('#SAVE.button.primary').click(function(event){
        CheckIfFormValid();

        if(isAllowSubmit){
            var _form = document.getElementById('EditView');
            _form.action.value = 'Save';
         
            if (check_form('EditView')){
                SUGAR.ajaxUI.submitForm(_form); // this will submit the form
            }
        }
    });

    $('.distribution_item').on('change', PopulateUOM);
    $('.distribution_item').trigger('change'); 

    $("#sync_to_contact_distribution_items").on('change', function() {
        if (this.checked) {
            var sync_confirm = confirm('Are you sure? This will overwrite the Contact\'s existing Distrbution Item(s)');

            if (! sync_confirm) {
                $(this).trigger('click');
            }
        }
    });

    $(".shipping_method").on('change', function() {
        $(this).parent().next().find('input.account_information').val('');

        if ($(this).val() === 'email') {
            $(this).parent().next().find('input.account_information').val($("#hidden-contact-email").val());
        }
    });

    $("#primary_address_street, #primary_address_city, #primary_address_state, #primary_address_postalcode, #primary_address_country, #alt_address_street, #alt_address_city, #alt_address_state, #alt_address_postalcode, #alt_address_country")
        .attr('readonly', 'readonly')
        .css('background', '#f8f8f8')
        .css('border', '1px solid #e2e7eb')
        .css('pointer-events','none');
    
    $("input[name='ship_to_address_c']").on('click', populateAddress);

    $("input[name='ship_to_address_c']:checked").trigger('click');
});

//OnTrack #1342 - populate one address
function populateAddress(e){
    var ship_to_address_c_val = $("input[name='ship_to_address_c']:checked").val();

    if(address != null && address.length > 0){
        if(ship_to_address_c_val == 'primary_address'){
            $('#primary_address_street').val(address[0].primary_address_street);
            $('#primary_address_city').val(address[0].primary_address_city);
            $('#primary_address_postalcode').val(address[0].primary_address_postalcode);

            $('#primary_address_state').val( () => {
                return $('#primary_address_state').find(`option[label='${address[0].primary_address_state}']`).val();
            });

            $('#primary_address_country').val( () => {
                return $('#primary_address_country').find(`option[label='${address[0].primary_address_country}']`).val();
            });
        }
        else if(ship_to_address_c_val == 'other_address'){
            $('#primary_address_street').val(address[1].alt_address_street);
            $('#primary_address_city').val(address[1].alt_address_city);
            $('#primary_address_postalcode').val(address[1].alt_address_postalcode);

            $('#primary_address_state').val( () => {
                return $('#primary_address_state').find(`option[label='${address[1].alt_address_state}']`).val();
            });

            $('#primary_address_country').val( () => {
                return $('#primary_address_country').find(`option[label='${address[1].alt_address_country}']`).val();
            });
        }
    }
    else{
        $('#primary_address_street').val('');
        $('#primary_address_city').val('');
        $('#primary_address_state').val('');
        $('#primary_address_postalcode').val('');
        $('#primary_address_country').val('');
    }
}

function Initialize()
{
    var tblLineItems = $('#tbl_line_items');
    var rowsObj = tblLineItems.find('tbody > tr');
    var rowCount = rowsObj.length;
    var currentRowObj = rowsObj.eq(rowCount - 1);

    if(rowCount == 1){
        currentRowObj.find('.distribution-remove').hide();
    }
    else if(rowCount > 1){
        $.each(rowsObj, function(index, val){
            if(index < (rowCount - 1))
            {
                $(val).find('.distribution-add').hide();
            }
        });
    }

    InitializeContact();
    
    YAHOO.util.Event.onDOMReady(function(){
        YAHOO.util.Event.addListener('account_c', 'change', InitializeContact);
        
        /**
         * Ontrack #1696
         * Handle Change TR on Create Distro
         * Distro Items dropdown should depend on parent TR => type
         */
        YAHOO.util.Event.addListener('technical_request_c', 'change', (event) => {
            let newTrId = jQuery('#tr_technicalrequests_id_c').val();
            if (newTrId != '' || newTrId != undefined) {
                handleDistroItemsDropdownFiltering(result => {
                    tblLineItems.find('tbody').html(result);
                    $('.distribution-add').on('click', AddDistributionItem);
                    $('.distribution-remove').on('click', Remove);
                    $('.distribution_item').on('change', PopulateUOM);
                    $('.distribution_item').trigger('change'); 
                    
                }, newTrId);

            }
        });
    });


    let old_contact_id = $("#contact_id_c").val();
    let new_contact_id = old_contact_id;
    let record_id = $("input[name='record'][type='hidden']").val();
    
    $('#custom_contact_id').parents('.edit-view-row-item').hide();
    setInterval(function(){ 
        var val = $('#contact_id_c').val();
        var contact_id_field = $('#custom_contact_id');

        if(val !== contact_id_field.val())
        {
            $('#custom_contact_id').val(val);
            var contact_id_c_val = $('#contact_id_c').val();
            $.post('index.php?', {action: 'quicksearchQuery', module:'Home', to_pdf:'true', data: '{"form":"EditView","method":"query","modules":["Contacts"],"group":"or","field_list":["id","name","primary_address_street","primary_address_city", "primary_address_state", "primary_address_postalcode", "primary_address_country", "alt_address_street","alt_address_city", "alt_address_state", "alt_address_postalcode", "alt_address_country"],"required_list":["parent_id"],"conditions":[{"name":"id","op":"equals","value":"'+ contact_id_c_val +'"}],"order":"name","limit":"30","no_match_text":"No Match"}'}, 'json')
            .done(function(data) {
                var dataObj = JSON.parse(data);
                var firstContact = dataObj.fields[0];

                if(contact_id_c_val != ''){
                    address = [{
                                'primary_address_street': firstContact.primary_address_street, 
                                'primary_address_city': firstContact.primary_address_city,
                                'primary_address_state': firstContact.primary_address_state,
                                'primary_address_postalcode': firstContact.primary_address_postalcode,
                                'primary_address_country': firstContact.primary_address_country,
                            },
                            {
                                'alt_address_street': firstContact.alt_address_street, 
                                'alt_address_city': firstContact.alt_address_city, 
                                'alt_address_state': firstContact.alt_address_state, 
                                'alt_address_postalcode': firstContact.alt_address_postalcode, 
                                'alt_address_country': firstContact.alt_address_country, 
                            }
                        ];
                } else{
                    address = [];
                }

                populateAddress(); //OnTrack #1342 - populate one address
            }).fail(function(data){
                alert("Try again champ!");
                console.log(data);
            });

            new_contact_id = val;
            
            if ((! record_id) || (old_contact_id !== new_contact_id && new_contact_id.length > 0)) {
                let tr_id = $("#tr_technicalrequests_id_c").val();

                $.post('index.php?', {
                    module: 'DSBTN_Distribution',
                    action: 'retrieve_contact_distribution_items',
                    to_pdf: true,
                    contact_id: new_contact_id,
                    tr_id: tr_id,
                }).done( (result) => {
                    var newIndex = parseInt($(".distro_item_assigned_user_name_button:last").attr('index')) + 1;
                    tblLineItems.find('tbody').html(result);

                    $('.distribution-add').on('click', AddDistributionItem);
                    $('.distribution-remove').on('click', Remove);
                    $('.distribution_item').on('change', PopulateUOM);
                    $('.distribution_item').trigger('change'); 

                    rowsObj = tblLineItems.find('tbody > tr');
                    rowCount = rowsObj.length;
                    currentRowObj = rowsObj.eq(rowCount - 1);

                    if(rowCount == 1){
                        currentRowObj.find('.distribution-remove').hide();
                    }
                    else if(rowCount > 1){
                        $.each(rowsObj, function(index, val){
                            if(index < (rowCount - 1))
                            {
                                $(val).find('.distribution-add').hide();
                            }
                        });
                    }

                    old_contact_id = new_contact_id;

                    $(".distro_item_assigned_user_name_button").each( (index, val) => {
                        $(val).attr('index', newIndex);

                        $(val).parent().find('input:not([type="hidden"])')
                            .attr('id', 'distro_item_assigned_user_name_' + newIndex)
                            .attr('name', 'distro_item_assigned_user_name[' + newIndex + ']');

                        $(val).parent().removeClass('yui-ac').find('div:first').remove();
                            
                        $(val).parent().find('input[type="hidden"]')
                            .attr('id', 'distro_item_assigned_user_id_' + newIndex)
                            .attr('name', 'distro_item_assigned_user_id[' + newIndex + ']');

                        $(val).attr(
                            'onclick', 
                            'open_popup("Users", 600, 400, "", true, false, {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"distro_item_assigned_user_id_' + newIndex + '","user_name":"distro_item_assigned_user_name_' + newIndex + '"}}, "single", true);'
                        );
                
                        sqs_objects['distro_item_assigned_user_name[' + newIndex + ']'] = {
                            "form":"EditView",
                            "method":"get_user_array",
                            "field_list":["user_name","id"],
                            "populate_list":['distro_item_assigned_user_name[' + newIndex + ']', 'distro_item_assigned_user_id[' + newIndex + ']'],
                            "required_list":['distro_item_assigned_user_id[' + newIndex + ']'],
                            "conditions":[{
                                "name":"user_name","op":"like_custom","end":"%","value":""
                            }],
                            "limit":"30","no_match_text":"No Match"
                        };

                        SUGAR.util.doWhen(
                            "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['distro_item_assigned_user_name[" + newIndex + "]']) != 'undefined'",
                            enableQS
                        );

                        newIndex = newIndex + 1;
                    });
                    
                    $(".shipping_method").each( function () {
                        if ($(this).val() === 'email') {
                            $(this).parent().next().find('input.account_information').val($("#hidden-contact-email").val());
                        }
                    }).on('change', function() {
                        $(this).parent().next().find('input.account_information').val(''); 

                        if ($(this).val() === 'email') {
                            $(this).parent().next().find('input.account_information').val($("#hidden-contact-email").val());
                        }
                    });

                });
            }

            ManageContactDuplicates(val);
        }
    }, 300);
}

function ManageTechnicalRequest()
{
    var previous_value = $('#tr_technicalrequests_id_c').val();
    var is_allow = true;
    var record_id = $("input[name='record'][type='hidden']").val();

    if (record_id && record_id.length > 0) {
        setInterval(function(){ 
            var new_value = $('#tr_technicalrequests_id_c').val();
            
            if (is_allow || previous_value != new_value) {
                $.ajax({
                    type: "POST",
                    url: "index.php?module=DSBTN_Distribution&action=get_tr_site_colormatch_coordinator&to_pdf=1",
                    data: {'tr_id' : new_value},
                    dataType: 'json',
                    success: function(response) {
                        if (site_colormatch_coordinator_id != response.data.site_colormatch_coordinator_id) {
                            $("#site_colormatch_coordinator_id").val(response.data.site_colormatch_coordinator_id);
                            $("#site_colormatch_coordinator_name").val(response.data.site_colormatch_coordinator_name);
    
                            if (site_colormatch_coordinator_id.length === 0) {
                                site_colormatch_coordinator_id = response.data.site_colormatch_coordinator_id;
                                site_colormatch_coordinator_name = response.data.site_colormatch_coordinator_name;
                            }
                            
                            MonitorSiteColormatchIdNameValues(site_colormatch_coordinator_id);
                        }
                    },
                    error: function(errorResponse) {
                        console.error(errorResponse);
                    }
                });
    
                is_allow = false;
                previous_value = new_value;
    
                if(previous_value == '' || previous_value == null) {
                    DisableSomeRecipientInfo();
                } else {
                    EnableSomeRecipientInfo();
                }
            }
        }, 600);
    }
}

const MonitorSiteColormatchIdNameValues = (prevId = '') => {
    $("input[id^='distro_item_assigned_user_id_']").each( (index, val) => {
        let field = $(val);
        
        site_colormatch_coordinator_id = $("#site_colormatch_coordinator_id").val();
        site_colormatch_coordinator_name = $("#site_colormatch_coordinator_name").val();

        if (prevId.length === 0 || prevId == field.val() || field.val().length === 0) {
            field.val(site_colormatch_coordinator_id);
            field.parent().find("input[id^='distro_item_assigned_user_name_']").val(site_colormatch_coordinator_name);
        }
        
    });
}

function DisableSomeRecipientInfo()
{
    $('#btn_account_c').attr('disabled', 'disabled');
    // $('#account_c').val('');
    $('#account_c').attr('disabled', 'disabled');
    $('#btn_clr_account_c').attr('disabled', 'disabled');
    $('#btn_contact_c').attr('disabled', 'disabled');
    $('#contact_c').attr('disabled', 'disabled');
    // $('#contact_c').val('');
    $('#btn_clr_contact_c').attr('disabled', 'disabled');
}

function EnableSomeRecipientInfo()
{
    $('#btn_account_c').removeAttr('disabled');
    $('#account_c').removeAttr('disabled');
    $('#btn_clr_account_c').removeAttr('disabled');
    $('#btn_contact_c').removeAttr('disabled');
    $('#contact_c').removeAttr('disabled');
    $('#btn_clr_contact_c').removeAttr('disabled');
}

function ManageContactDuplicates(contact_id)
{
    var tr_id = '';
    var postData = {'tr_id': $('#tr_technicalrequests_id_c').val(),
                    'contact_id': contact_id,
                    'distribution_id': $('#distribution_id').val()};

    if(contact_id != null && contact_id != '')
    {
        $.ajax({
            type: "POST",
            url: "index.php?module=DSBTN_Distribution&action=is_contact_exist&to_pdf=1",
            data: postData,
            dataType: 'json',
            success: function(result){
                if(result.success && result.data.is_exist)
                {
                    alert('This contact already exists in Distribution #'+ result.data.distribution_detail.distro_num + ' for ' + result.data.distribution_detail.tr_name);
                    
                    $('#contact_id_c').val('');

                    $('#primary_address_street').val('');
                    $('#primary_address_city').val('');
                    $('#primary_address_state').val('').change();
                    $('#primary_address_postalcode').val('');
                    $('#primary_address_country').val('').change();

                    $('#alt_address_street').val('');
                    $('#alt_address_city').val('');
                    $('#alt_address_state').val('').change();
                    $('#alt_address_postalcode').val('');
                    $('#alt_address_country').val('').change();

                    $('#contact_c').val('');
                }
            },
            error: function(result){
                console.log(result);
                //alert('error');
            }
        });
    }
}

function PopulateUOM(e)
{
    var dropdown = $(e.currentTarget);
    var description = dropdown.find('option:selected').data('description');
    var tr = dropdown.parents('tr');
    tr.find('.uom').html(description);
    tr.find('.uomHidden').val(description);
}

function Remove(e)
{
    $(e.currentTarget).parents('tr').remove();

    var tblLineItems = $('#tbl_line_items');
    var rowsObj = tblLineItems.find('tbody > tr');
    var rowCount = rowsObj.length;

    if(rowCount == 1){
        rowsObj.eq(0).find('.distribution-remove').hide();
        rowsObj.eq(0).find('.distribution-add').show();
    } else {
        rowsObj.last().find('.distribution-add').show();
    }
}

function AddDistributionItem(e)
{
    var tblLineItems = $('#tbl_line_items');
    var currentAddButton = $(e.currentTarget);
    var currentRowObj = currentAddButton.parent().parent();

    if(IsValidRowItems(currentRowObj))
    {
        var clonnedRow = currentRowObj.clone();
        var assignedToRelateBtn = clonnedRow.find('.distro_item_assigned_user_name').parent().find('button');
        var newRowKey = parseInt($(".distro_item_assigned_user_name_button:last").attr('index')) + 1;

        clearRow(clonnedRow, assignedToRelateBtn, newRowKey);

        tblLineItems.find('tbody').append(clonnedRow);
        currentRowObj.find('.distribution-remove').show();
        currentRowObj.find('.distribution-add').hide();
        clonnedRow.find('.distribution-add').on('click', AddDistributionItem);
        clonnedRow.find('.distribution-remove').on('click', Remove);
        clonnedRow.find('.distribution-remove').show();
        clonnedRow.find('.distribution_item').on('change', PopulateUOM);

        // Modify Popup button onclick action to set selected option on new Assigned To row
        assignedToRelateBtn.attr('index', newRowKey).attr('onclick', 
            'open_popup("Users", 600, 400, "", true, false, {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"distro_item_assigned_user_id_' + newRowKey + '","user_name":"distro_item_assigned_user_name_' + newRowKey + '"}}, "single", true);'
        );

        sqs_objects['distro_item_assigned_user_name[' + newRowKey + ']'] = {
            "form":"EditView",
            "method":"get_user_array",
            "field_list":["user_name","id"],
            "populate_list":['distro_item_assigned_user_name[' + newRowKey + ']', 'distro_item_assigned_user_id[' + newRowKey + ']'],
            "required_list":['distro_item_assigned_user_id[' + newRowKey + ']'],
            "conditions":[{
                "name":"user_name","op":"like_custom","end":"%","value":""
            }],
            "limit":"30","no_match_text":"No Match"
        };
    
        SUGAR.util.doWhen(
            "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['distro_item_assigned_user_name[" + newRowKey + "]']) != 'undefined'",
            enableQS
        );

        $(".shipping_method").on('change', function() {
            $(this).parent().next().find('input.account_information').val('');
    
            if ($(this).val() === 'email') {
                $(this).parent().next().find('input.account_information').val($("#hidden-contact-email").val());
            }
        });
    }
    else{
        alert('Please populate all fields or remove the row');
    }
}

function clearRow(row, assignedToRelateBtn, newRowKey)
{
    row.find('.qty').val('');
    row.find('.uom').html('');
    row.find(".distribution_item").val($(".distribution_item option:first").val());
    row.find('.shipping_method').val('');
    row.find('.account_information').val('');
    row.find('.status').val('new');
    
    // Udpdate Clonned Row Key then Clear Name and ID - Assigned To field
    assignedToRelateBtn.parent().find('input:not([type="hidden"])')
        .attr('id', 'distro_item_assigned_user_name_' + newRowKey)
        .attr('name', 'distro_item_assigned_user_name[' + newRowKey + ']')
        .val(site_colormatch_coordinator_name);

    assignedToRelateBtn.parent().removeClass('yui-ac').find('div:first').remove();
        
    assignedToRelateBtn.parent().find('input[type="hidden"]')
        .attr('id', 'distro_item_assigned_user_id_' + newRowKey)
        .attr('name', 'distro_item_assigned_user_id[' + newRowKey + ']')
        .val(site_colormatch_coordinator_id);
} 

function CheckIfFormValid()
{
    var tblLineItems = $('#tbl_line_items');
    var rowsObj = tblLineItems.find('tbody > tr');
    var result = false;

    if(rowsObj.length > 1){
        $.each(rowsObj, function(index, val){
            var row = $(val);
            result = IsValidRowItems(row, true);
        });

        if(!result){
            alert('Please populate all fields or remove the row!');
        }
    }
    else
    {
        var row = rowsObj.eq(0);
        result = IsValidRowItems(row, false);

        if(!result){
            alert('Please put atleast one Distribution Item');
        }
    }

    isAllowSubmit = result;

    return result;
}

function IsValidRowItems(row, isForceCHeckRow = false)
{
    var result = true;
    var qty = row.find('.qty').val();
    var distributionItem = row.find('.distribution_item option:selected').val();
    var shipping_method = row.find('.shipping_method option:selected').val();
    var status = row.find('.status').val();

    if(qty == '' && distributionItem == '' && shipping_method == '' && status == '' && isForceCHeckRow)
    {
        result = true;
    }
    else
    {
        if(qty == null || qty == "")
        {
            result = false;
        }
    
        if(distributionItem == null || distributionItem == "")
        {
            result = false;
        }
    
        if(shipping_method == null || shipping_method == "")
        {
            result = false;
        }

        if(status == null || status == "")
        {
            result = false;
        }
    }

    return result;
}

function InitializeContact()
{
    var accound_id = $('#account_id_c').val();
    var recordID_val = $('#recordID').val();

    sqs_objects['EditView_contact_c']['conditions'][1] = {
        name: "account_c",
        op: "equals",
        value: accound_id
    };
    sqs_objects['EditView_contact_c']['group'] = 'and';

    SUGAR.util.doWhen(
        "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['EditView_contact_c']) != 'undefined'",
        enableQS
    );
}

function fieldAutoComplete(){
    $('#contact_c').removeClass('sqsEnabled');
    $('#contact_c').addClass('sqsDisabled');
    setTimeout(function(){
        $('#contact_c').removeClass('sqsDisabled');
        $('#contact_c').addClass('sqsEnabled');
    }, 100);



    /*
    $( "#contact_c" ).autocomplete({ //select the field we want to autocomplete with jquery
      source: function(request, response) { //we need to customize the source
        var account_id_c = $('#account_id_c').val();
        $.post('index.php?', {action: 'quicksearchQuery', module:'Home', to_pdf:'true', data: '{"form":"EditView","method":"query","modules":["Contacts"],"group":"or","field_list":["id","name","primary_address_street","primary_address_city", "primary_address_state", "primary_address_postalcode", "primary_address_country", "alt_address_street","alt_address_city", "alt_address_state", "alt_address_postalcode", "alt_address_country"],"populate_list":["contact_c","contact_id_c"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}, {"name":"account_c","op":"like_custom","end":"%","value":"'+ account_id_c +'"}],"order":"name","limit":"30","no_match_text":"No Match"}', query: request.term}, response, 'json')
        .done(function(data) { //this will process the response received since the autocomplete needs an array with the values and the response brings extra info
           response($.map( data.fields, function( item ) {
               return {
                   label: item.name,
                   value: item.id,
                   primary_address_street: item.primary_address_street,
                   primary_address_city: item.primary_address_city,
                   primary_address_state: item.primary_address_state,
                   primary_address_postalcode: item.primary_address_postalcode,
                   primary_address_country: item.primary_address_country,
                   alt_address_street: item.alt_address_street,
                   alt_address_city: item.alt_address_city,
                   alt_address_state: item.alt_address_state,
                   alt_address_postalcode: item.alt_address_postalcode,
                   alt_address_country: item.alt_address_country,
               }
           }));
        });
      },
     minLength: 2,
     select: function( event, ui ) { //this will enter the selected values into the correct fields, modify according to your fields but do not forget the hidden ID field.
       $('#contact_c').val(ui.item.label);
       $('#contact_id_c').val(ui.item.value);

       $('#primary_address_street').val(ui.item.primary_address_street);
       $('#primary_address_city').val(ui.item.primary_address_city);
       $('#primary_address_postalcode').val(ui.item.primary_address_postalcode);

       $('#primary_address_state').val( () => {
         return $('#primary_address_state').find(`option[label='${ui.item.primary_address_state}']`).val();
       }).change();

       $('#primary_address_country').val( () => {
         return $('#primary_address_country').find(`option[label='${ui.item.primary_address_country}']`).val();
       }).change();

       $('#alt_address_street').val(ui.item.alt_address_street);
       $('#alt_address_city').val(ui.item.alt_address_city);
       $('#alt_address_postalcode').val(ui.item.alt_address_postalcode);

       $('#alt_address_state').val( () => {
        return $('#alt_address_state').find(`option[label='${ui.item.alt_address_state}']`).val();
       }).change();

       $('#alt_address_country').val( () => {
        return $('#alt_address_country').find(`option[label='${ui.item.alt_address_country}']`).val();
       }).change();

       return false;
     }
     }).autocomplete( "instance" )._renderItem = function( ul, item ) { //this formats the results display. In my case I needed extra info to differentiate between similar items
       return $( "<li>" )
         .append( "<div>" + item.label +  "</div>" )
         .appendTo( ul );
     };
     */
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

const handleDistroItemsDropdownFiltering = (callback, newTrId) => {
   
    jQuery.get( "index.php?",{
        module: 'DSBTN_Distribution',
        action: 'retrieve_dsbtn_items_dropdown_list',
        to_pdf: true,
        tr_id: newTrId,
    }).done(result => {
        callback(result)
    });
}