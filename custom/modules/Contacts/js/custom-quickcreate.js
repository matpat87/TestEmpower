const handleCopyAccountAddress = () => {
  jQuery('input[name=copy_addres_btn]').on('click', function() {
    console.log("qc handle copy account address")
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

jQuery(document).ready(function() {
  window.onbeforeunload = null; // Need to add this to resolve issue where it keep showing "Are you sure you want to leave?" when selecting a contact via popup
  
  $.getJSON('./custom/include/json/complete_country_list.json', function(data){
    var primaryAddressFieldValues = {
      'country': $("#primary_address_country").val(),
      'state': $("#primary_address_state").val(),
    };

    countryChanged(data);
    stateDynamicDropdownList(primaryAddressFieldValues, null, data);

  });
    
  if (jQuery('#form_QuickCreate_Contacts').length > 0 || jQuery('form#form_SubpanelQuickCreate_Contacts').length > 0) {
      jQuery("div[data-label=LBL_PRIMARY_ADDRESS_COUNTRY]")
      .parent('.edit-view-row-item')
      .next()
      .html('<div class="col-xs-12 col-sm-12 edit-view-field"><input type="button" id="copy-address-btn" name="copy_addres_btn" value="Copy Account Address" /></div>');

      handleCopyAccountAddress();

      //OnTrack #1200 - Trigger Copy Address during load
      $('#primary_address_country').val($('#primary_address_country option:first').val()); 
      $('#primary_address_city').val('');
      $('#primary_address_street').val('');
      $('#primary_address_postalcode').val('');
  }
});

function countryChanged(countries) {
  
    $("#primary_address_country").on('change', function() {
      stateDynamicDropdownList({ 'country': $(this).val()}, null, countries);
    });

  
}

function stateDynamicDropdownList(fieldValues, childFieldStr, jsonList) {
  
  childFieldStr = childFieldStr || "#primary_address_state";
  var stateDropdownList = (fieldValues.country != "") 
    ? filterCountryJsonList(jsonList, 'country_code', fieldValues.country)
    : [];
  
  resetDropdownList(childFieldStr, stateDropdownList, fieldValues.state);
  
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
  triggerOptionalStateFieldValidation(options)
}

// TRIGGERED WHEN STATE FIELD HAS NO OPTIONS OTHER THAN BLANK VALUE
function triggerOptionalStateFieldValidation(stateOptions) {
  let countryValue = jQuery('#primary_address_country').val();
  
  if (Array.isArray(stateOptions) && stateOptions.length == 0 && countryValue != '') {
    removeFromValidate('form_QuickCreate_Contacts', 'primary_address_state');
    jQuery('#primary_address_state').removeAttr('style');
    jQuery('#primary_address_state').siblings('.validation-message').css('display', 'none');
  } else {
    addToValidate('form_QuickCreate_Contacts', 'primary_address_state', 'enum', true, 'State');
  }
}

function filterCountryJsonList(jsonList, filterBy, filterValue) {
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
