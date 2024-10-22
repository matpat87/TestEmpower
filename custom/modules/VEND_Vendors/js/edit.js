$(document).ready(function() {
    setNonDbFieldsTabDisplay();
    
    $.getJSON('./custom/include/json/complete_country_list.json', function(data) {
        var fieldValues = {
            'shipping_country': $(".edit-view-field #shipping_address_country").val(),
            'shipping_state': $(".edit-view-field #shipping_address_state").val(),
        };
        
        // Validated Address country and state dropdown values
        var billingStateFieldValues = {
            shipping_country: $(".edit-view-field #billing_address_country").val(),
            shipping_state: $(".edit-view-field #billing_address_state").val(),
        };
        
  
        countryChanged(data);
        stateDynamicDropdownList(fieldValues, null, data);
        stateDynamicDropdownList(
            billingStateFieldValues,
            ".edit-view-field #billing_address_state",
            data
        );
    });
  });
  
  function countryChanged(countries) {
    $(".edit-view-field #shipping_address_country").on('change', function() {
        stateDynamicDropdownList({ 'shipping_country': $(this).val()}, null, countries);
    });
  
    $(".edit-view-field #billing_address_country").on("change", function () {
        stateDynamicDropdownList(
            { shipping_country: $(this).val() },
            ".edit-view-field #billing_address_state",
            countries
        );
    });
  }
  
  function stateDynamicDropdownList(fieldValues, childFieldStr, jsonList)
  {
    childFieldStr = childFieldStr || ".edit-view-field #shipping_address_state";
    var stateDropdownList = filterCountryJsonList(jsonList, 'country_code', fieldValues.shipping_country);
  
    resetDropdownList(childFieldStr, stateDropdownList ,fieldValues.shipping_state);
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
  
  function filterCountryJsonList(jsonList, filterBy, filterValue) {
    var dropdwonList = jsonList.filter(function(data) {
      if (filterBy == 'country_code') {
        return (data['country_code'] == filterValue || data['country_code_3'] == filterValue) && data['type'] != 'country';
      } else {
        return data[filterBy] == filterValue;
      }
    }).map(function(item) {
        var obj = {};
        obj.label = item.name;
        obj.value = item.code;
  
        return obj;
    });
  
    return dropdwonList;
  }

  function setNonDbFieldsTabDisplay() {
    let panel_bg_color = 'var(--custom-panel-bg)';
		
    $("div[field='marketing_information_non_db'],div[field='erp_data_non_db']")
      .prev()
      .removeClass('col-sm-2')
      .addClass('col-sm-12')
      .addClass('col-md-12')
      .addClass('col-lg-12')
      .css('background-color', panel_bg_color)
      .css('color', '#FFF')
      .css('margin-top', '15px')
      .css('padding', '0px 0px 8px 10px')
      .parent()
      .css('padding-left', '0px');

    $("div[field='marketing_information_non_db']")
      .prev()
      .css('margin-top', '0px');

    $("div[field='marketing_information_non_db'],div[field='erp_data_non_db']")
      .addClass('hidden');
  }