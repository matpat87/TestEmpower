// const { isArray } = require("jquery");

var isAllowSubmit = false;

$(document).ready(function() {
  $.getJSON('./custom/include/json/complete_country_list.json', function(data){
    var primaryAddressFieldValues = {
      'country': $(".edit-view-field #primary_address_country, #Contactsprimary_address_country").val(),
      'state': $(".edit-view-field #primary_address_state, #Contactsprimary_address_state").val(),
      
    };

    var altAddressFieldValues = {
      'country': $(".edit-view-field #alt_address_country").val(),
      'state': $(".edit-view-field #alt_address_state").val(),
    };

    
    countryChanged(data);
    stateDynamicDropdownList(primaryAddressFieldValues, null, data);
    stateDynamicDropdownList(
      altAddressFieldValues, 
      ".edit-view-field #alt_address_state", 
      data);

    });
    
  initializeDistributionTab();
  $('.nav.nav-tabs a').not('.dropdown-toggle').on('click', function (event) {
    var the_id = event.target.id;

    if (the_id == 'tab0') {
        $('.panel-content').show();
    } else {
        $('.panel-content').hide();
    }
  });

  jQuery("#PRIMARY_address_fieldset legend")
    .css({
      'display': 'flex',
      'justify-content': 'space-between',
      'align-items': 'center'
    }).html('<span>Primary Address</span><input type="button" id="copy-address-btn" name="copy_addres_btn" value="Copy Account Address" />');
 
  handleCopyAccountAddress();
});

function countryChanged(countries) {
  if (!check_form('ConvertLead')) {
    // if form is in Convert lead
    $("#Contactsprimary_address_country").on('change', function() {
      stateDynamicDropdownList({ 
        'country': $(this).val()}, 
        "#Contactsprimary_address_state", 
        countries);
    });
  
    $("#Contactsalt_address_country").on('change', function() {
      stateDynamicDropdownList({ 'country': $(this).val() }, 
      "#Contactsalt_address_state", 
        countries);
    });
    
  } else {
    $(".edit-view-field #primary_address_country").on('change', function() {
      stateDynamicDropdownList({ 'country': $(this).val()}, null, countries);
    });
  
    $(".edit-view-field #alt_address_country").on('change', function() {
      stateDynamicDropdownList({ 'country': $(this).val() }, 
      ".edit-view-field #alt_address_state", 
        countries);
    });

  }
}

function stateDynamicDropdownList(fieldValues, childFieldStr, jsonList) {
  childFieldStr = childFieldStr || ".edit-view-field #primary_address_state";
  var stateDropdownList = (fieldValues.country != "") 
    ? filterCountryJsonList(jsonList, 'country_code', fieldValues.country)
    : [];
  console.log(stateDropdownList);
  resetDropdownList(childFieldStr, stateDropdownList, fieldValues.state);


  
}

function resetDropdownList(field, options, fieldVal) {
  $(field)
      .find('option')
      .remove()
      .end();

  $(field).append('<option label="" value=""></option>'); // Added a blank option on top of dropdown list
  options.map( ( option ) => {
      $(field).append('<option label="'+ option.label +'" value="'+ option.value +'">'+ option.label +'</option>');
  });
  
  fieldVal ? $(field).val(fieldVal) : $(field).val($(field).find('option').first().val());
  triggerOptionalStateFieldValidation(options)
}

function initializeDistributionTab() {
  var distributionLineItemField = $("div[field='custom_line_items_non_db']");

  distributionLineItemField
    .removeClass('col-sm-8')
    .addClass('col-sm-12 col-md-1 col-lg-12')
    .parent().find('div:first').hide();

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

  $('.distribution-add').on('click', addDistributionItem);
  $('.distribution-remove').on('click', removeDistributionItem);
  $('.distribution_item').on('change', populateDistributionItemUOM);
  $('.distribution_item').change();

  $(".shipping_method").on('change', function() {
    $(this).parent().next().find('input.account_information').val('');

    if ($(this).val() === 'email') {
        $(this).parent().next().find('input.account_information').val($("#hidden-contact-email").val());
    }
  });

  $("#SAVE.button.primary").removeAttr('accesskey');
  $("#SAVE.button.primary").removeAttr('onclick');
  $("#SAVE.button.primary").removeAttr('type');
  $("#SAVE.button.primary").attr('type', 'button');

  $('#SAVE.button.primary').click(function(event){
      checkIfFormValid();

      if(isAllowSubmit){
          var _form = document.getElementById('EditView');
          _form.action.value = 'Save';
        
          if (check_form('EditView')){
              SUGAR.ajaxUI.submitForm(_form); // this will submit the form
          }
      }
  });
}

function addDistributionItem(e) {
  var tblLineItems = $('#tbl_line_items');
  var currentAddButton = $(e.currentTarget);
  var currentRowObj = currentAddButton.parent().parent();
  
  if(isValidRowItems(currentRowObj)) {
    var clonnedRow = currentRowObj.clone();
    clearDistributionItemRow(clonnedRow);
    tblLineItems.find('tbody').append(clonnedRow);
    currentRowObj.find('.distribution-remove').show();
    currentRowObj.find('.distribution-add').hide();
    clonnedRow.find('.distribution-add').on('click', addDistributionItem);
    clonnedRow.find('.distribution-remove').on('click', removeDistributionItem);
    clonnedRow.find('.distribution-remove').show();
    clonnedRow.find('.distribution_item').on('change', populateDistributionItemUOM);

    $(".shipping_method").on('change', function() {
      $(this).parent().next().find('input.account_information').val('');

      if ($(this).val() === 'email') {
          $(this).parent().next().find('input.account_information').val($("#hidden-contact-email").val());
      }
    });

  } else {
    alert('Please populate all fields or remove the row');
  }
}

function removeDistributionItem(e) {
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

function clearDistributionItemRow(row) {
  row.find('.qty').val('');
  row.find('.uom').html('');
  row.find(".distribution_item").val($(".distribution_item option:first").val());
  row.find('.shipping_method').val('');
  row.find('.account_information').val('');
}

function populateDistributionItemUOM(e)
{
  var dropdown = $(e.currentTarget);
  var description = dropdown.find('option:selected').data('description');
  var tr = dropdown.parents('tr');
  tr.find('.uom').html(description);
  tr.find('.uomHidden').val(description);
}

function checkIfFormValid() {
    var tblLineItems = $('#tbl_line_items');
    var rowsObj = tblLineItems.find('tbody > tr');
    var result = false;

    if(rowsObj.length >= 1){
        $.each(rowsObj, function(index, val){
            var row = $(val);
            result = isValidRowItems(row, true);
        });

        if(!result){
            alert('Please populate all fields or remove the row!');
        }
    }
    else
    {
      result = true;
    }

    isAllowSubmit = result;

    return result;
}

function isValidRowItems(row, isForceCHeckRow = false) {
    var result = true;
    var qty = row.find('.qty').val();
    var distributionItem = row.find('.distribution_item option:selected').val();
    var shipping_method = row.find('.shipping_method option:selected').val();
    
    if(qty == '' && distributionItem == '' && shipping_method == '' && isForceCHeckRow)
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
    }

    return result;
}


function filterCountryJsonList(jsonList, filterBy, filterValue) {
    console.log(filterBy, filterValue);
  var dropdwonList = jsonList.filter(function(data) {
    if (filterBy == 'country_code') {
      return (data['country_code'] == filterValue || data['country_code_3'] == filterValue) && data['type'] != 'country';
    } else {
      return data[filterBy] == filterValue;
    }
  }).map(function(item) {
      var obj = {};
      obj.label = item['name'];
      obj.value = item['3166_code'];

      return obj;
  });
  
  return dropdwonList;

}

const handleCopyAccountAddress = () => {
  jQuery('#copy-address-btn').on('click', function() {
    let accountID = $('#account_id[type=hidden]').val();
    if (!accountID) {
      alert('No Account selected');
    } else {
      $.ajax({
        url: "index.php?module=Contacts&action=get_account_address&to_pdf=1",
        type: "GET",
        data: { 'account_id': accountID },
        success: function(result){
          let dataObj = JSON.parse(result);

          if (dataObj) {

            jQuery("select#primary_address_country").val(dataObj.billing_address_country).trigger('change');
            jQuery("#primary_address_street").val(dataObj.billing_address_street);
            jQuery("#primary_address_city").val(dataObj.billing_address_city);
            jQuery("#primary_address_state").val(dataObj.billing_address_state ).trigger("change");
            jQuery("#primary_address_postalcode").val(dataObj.billing_address_postalcode );
          }
        },
        error: function(response) {
            console.log("error: ", response)
        } 
      }); 

    }
  });
}

// TRIGGERED WHEN STATE FIELD HAS NO OPTIONS OTHER THAN BLANK VALUE
function triggerOptionalStateFieldValidation(stateOptions) {
  let countryValue = jQuery('#primary_address_country').val();
  
  if (Array.isArray(stateOptions) && stateOptions.length == 0 && countryValue != '') {
    removeFromValidate('EditView', 'primary_address_state');
    jQuery('#primary_address_state').removeAttr('style');
    jQuery('#primary_address_state').siblings('.validation-message').css('display', 'none');
  } else {
    addToValidate('EditView', 'primary_address_state', 'enum', true, 'State');
  }
}