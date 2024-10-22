$(document).ready(function() {


  $.getJSON('./custom/include/json/complete_country_list.json', function(data) {
    
    var fieldValues = {
      'shipping_country': $(".edit-view-field #shipping_address_country, #shipping_address_country_advanced").val(),
      'shipping_state': $(".edit-view-field #shipping_address_state, #shipping_address_state_advanced").val(),
    };
  
    // Validated Address country and state dropdown values
      var billingStateFieldValues = {
          shipping_country: $(".edit-view-field #billing_address_country, #billing_address_country_advanced").val(),
          shipping_state: $(".edit-view-field #billing_address_state, #billing_address_state_advanced").val(),
      };
      
    $('input#annual_revenue_potential_c').on('focus', function() {
      $(this.select())
    });

    countryChanged(data);
    customValidateCurrencyField();
    stateDynamicDropdownList(fieldValues, null, data);
    stateDynamicDropdownList(
          billingStateFieldValues,
          ".edit-view-field #billing_address_state",
          data
      );
      
    if ($("form#search_form").length > 0) {
      stateDynamicDropdownList(
          billingStateFieldValues,
          "#billing_address_state_advanced",
          data
      );
      stateDynamicDropdownList(
          fieldValues,
          "#shipping_address_state_advanced",
          data
      );
    }
  });

  

  // customRelateFieldAutocomplete(['Users'], 'users_accounts_1_name', {
  //   "name": 'role_c', // name of field to apply filter
  //   "op": "equal", // Operator
  //   "value": 'StrategicAccountManager' // Value to compare
  // });

  // customRelateFieldAutocomplete(['Users'], 'users_accounts_2_name', {
  //   "name": 'role_c', // name of field to apply filter
  //   "op": "equal", // Operator 
  //   "value": 'MarketDevelopmentManager' // Value to compare
  // });
  
  // onChangeOEMDropdownHandler();
  onChangeAccountTypeDropdownHandler();

  // onAccountTypeChanged(); Deprecated?
});

function onlyNumberKey(evt) {
             
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  
    if(charCode==46){
        var txt=document.getElementById(id).value;
        if(!(txt.indexOf(".") > -1)){

            return true;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57) )
        return false;

    return true;

}

function customRelateFieldAutocomplete(moduleArray, field, conditions) {
  var formName='EditView_'; // form name
  var fieldName= field; // field name to override SQS

  var sqsId = formName + fieldName;
  sqs_objects[sqsId]['method'] = "query";
  sqs_objects[sqsId]['modules'] = moduleArray;
  sqs_objects[sqsId]['field_list'] = ['name', 'id'];
  sqs_objects[sqsId]['conditions'] = [{
      "name": "name",
      "op": "like_custom",
      "end": "%",
      "value": ""
    }, conditions
  ];
  sqs_objects[sqsId]['group'] = "and";
}

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

  if ($("form#search_form").length > 0) { // if from Advanced search
    $("#billing_address_country_advanced").on("change", function () {
          stateDynamicDropdownList(
              { shipping_country: $(this).val() },
              "#billing_address_state_advanced",
              countries
          );
    });

    $("#shipping_address_country_advanced").on("change", function () {
          stateDynamicDropdownList(
              { shipping_country: $(this).val() },
              "#shipping_address_state_advanced",
              countries
          );
     });

  }
}

function stateDynamicDropdownList(fieldValues, childFieldStr, jsonList)
{
  childFieldStr = childFieldStr || ".edit-view-field #shipping_address_state";
  if ($("form#search_form").length > 0) {
    var stateDropdownList = (fieldValues.shipping_country != "")
      ? filterCountryJsonList(jsonList, 'country_code', fieldValues.shipping_country, true)
      : filterCountryJsonList(jsonList, 'type', "country", false);

  } else {
    var stateDropdownList = (fieldValues.shipping_country != "")
      ? filterCountryJsonList(jsonList, 'country_code', fieldValues.shipping_country)
      : [];
  }
  

  resetDropdownList(childFieldStr, stateDropdownList ,fieldValues.shipping_state);

  // switch (fieldValues.shipping_country) {
  //   case 'USA':
  //   case 'US':
      
  //     var options = [
  //       { value: '',   label: '' },
  //       { value: 'AL', label: 'Alabama' },
  //       { value: 'AK', label: 'Alaska' },
  //       { value: 'AZ', label: 'Arizona' },
  //       { value: 'AR', label: 'Arkansas' },
  //       { value: 'CA', label: 'California' },
  //       { value: 'CO', label: 'Colorado' },
  //       { value: 'CT', label: 'Connecticut' },
  //       { value: 'DE', label: 'Delaware' },
  //       { value: 'DC', label: 'District Of Columbia' },
  //       { value: 'FL', label: 'Florida' },
  //       { value: 'GA', label: 'Georgia' },
  //       { value: 'HI', label: 'Hawaii' },
  //       { value: 'ID', label: 'Idaho' },
  //       { value: 'IL', label: 'Illinois' },
  //       { value: 'IN', label: 'Indiana' },
  //       { value: 'IA', label: 'Iowa' },
  //       { value: 'KS', label: 'Kansas' },
  //       { value: 'KY', label: 'Kentucky' },
  //       { value: 'LA', label: 'Louisiana' },
  //       { value: 'ME', label: 'Maine' },
  //       { value: 'MD', label: 'Maryland' },
  //       { value: 'MA', label: 'Massachusetts' },
  //       { value: 'MI', label: 'Michigan' },
  //       { value: 'MN', label: 'Minnesota' },
  //       { value: 'MS', label: 'Mississippi' },
  //       { value: 'MO', label: 'Missouri' },
  //       { value: 'MT', label: 'Montana' },
  //       { value: 'NE', label: 'Nebraska' },
  //       { value: 'NV', label: 'Nevada' },
  //       { value: 'NH', label: 'New Hampshire' },
  //       { value: 'NJ', label: 'New Jersey' },
  //       { value: 'NM', label: 'New Mexico' },
  //       { value: 'NY', label: 'New York' },
  //       { value: 'NC', label: 'North Carolina' },
  //       { value: 'ND', label: 'North Dakota' },
  //       { value: 'OH', label: 'Ohio' },
  //       { value: 'OK', label: 'Oklahoma' },
  //       { value: 'OR', label: 'Oregon' },
  //       { value: 'PA', label: 'Pennsylvania' },
  //       { value: 'RI', label: 'Rhode Island' },
  //       { value: 'SC', label: 'South Carolina' },
  //       { value: 'SD', label: 'South Dakota' },
  //       { value: 'TN', label: 'Tennessee' },
  //       { value: 'TX', label: 'Texas' },
  //       { value: 'UT', label: 'Utah' },
  //       { value: 'VT', label: 'Vermont' },
  //       { value: 'VA', label: 'Virginia' },
  //       { value: 'WA', label: 'Washington' },
  //       { value: 'WV', label: 'West Virginia' },
  //       { value: 'WI', label: 'Wisconsin' },
  //       { value: 'WY', label: 'Wyoming' }
  //     ];

  //     resetDropdownList(childFieldStr, options, fieldValues.shipping_state);
  //     break;

  //   case 'CAN':
  //   case 'CA':

  //     var options = [
  //       { value: ''  , label: '' },
  //       { value: 'AB', label: 'Alberta' },
  //       { value: 'BC', label: 'British Columbia' },
  //       { value: 'MB', label: 'Manitoba' },
  //       { value: 'NB', label: 'New Brunswick' },
  //       { value: 'NL', label: 'Newfoundland and Labrador' },
  //       { value: 'NS', label: 'Nova Scotia' },
  //       { value: 'ON', label: 'Ontario' },
  //       { value: 'PE', label: 'Prince Edward Island' },
  //       { value: 'QC', label: 'Quebec' },
  //       { value: 'SK', label: 'Saskatchewan' }
  //     ]

  //     resetDropdownList(childFieldStr,options ,fieldValues.shipping_state);
  //     break;
    
  //   case 'MEX':
  //   case 'MX':

  //     var options = [
  //       { value: '', label: '' },
  //       { value: 'AGU', label: 'Aguascalientes' },
  //       { value: 'BCN', label: 'Baja California' },
  //       { value: 'BCS', label: 'Baja California Sur' },
  //       { value: 'CAM', label: 'Campeche' },
  //       { value: 'CHP', label: 'Chiapas' },
  //       { value: 'CHH', label: 'Chihuahua' },
  //       { value: 'COA', label: 'Coahuila' },
  //       { value: 'COL', label: 'Colima' },
  //       { value: 'DUR', label: 'Durango' },
  //       { value: 'GUA', label: 'Guanajuato' },
  //       { value: 'GRO', label: 'Guerrero' },
  //       { value: 'HID', label: 'Hidalgo' },
  //       { value: 'JAL', label: 'Jalisco' },
  //       { value: 'MEX', label: 'Mexico' },
  //       { value: 'CMX', label: 'Mexico City' },
  //       { value: 'MIC', label: 'Michoacan' },
  //       { value: 'MOR', label: 'Morelos' },
  //       { value: 'NAY', label: 'Nayarit' },
  //       { value: 'NLE', label: 'Nuevo Leon' },
  //       { value: 'OAX', label: 'Oaxaca' },
  //       { value: 'PUE', label: 'Puebla' },
  //       { value: 'QUE', label: 'Queretaro' },
  //       { value: 'ROO', label: 'Quintana Roo' },
  //       { value: 'SLP', label: 'San Luis Potosi' },
  //       { value: 'SIN', label: 'Sinaloa' },
  //       { value: 'SON', label: 'Sonora' },
  //       { value: 'TAB', label: 'Tabasco' },
  //       { value: 'TAM', label: 'Tamaulipas' },
  //       { value: 'TLA', label: 'Tlaxcala' },
  //       { value: 'VER', label: 'Veracruz' },
  //       { value: 'YUC', label: 'Yucatan' },
  //       { value: 'ZAC', label: 'Zacatecas' },
  //     ]

  //     resetDropdownList(childFieldStr,options ,fieldValues.shipping_state);
  //     break;
  //   default:
  //     var options = [
  //       { value: '',   label: '' },
  //     ]

  //     resetDropdownList(childFieldStr,options ,fieldValues.shipping_state);
  //     break;
  // }
}

function resetDropdownList(field, options, fieldVal) {
  $(field)
      .find('option')
      .remove()
      .end();
  $(field).append('<option value=""></option>');
  options.map( ( option, index ) => {
    $(field).append('<option label="'+ option.label +'" value="'+ option.value +'">'+ option.label +'</option>');
  });
  
  fieldVal ? $(field).val(fieldVal) : $(field).val($(field).find('option').first().val());
}

function onChangeOEMDropdownHandler() {
  $("#oem_c").on('change', function() {
    let val = $(this).val();
    let companyType = $("#manufacturing_type_c");
    
    if (val == 'Yes') {
      companyType.val('Other');
    } else {
      companyType.val('');
    }
  })
}

function onChangeAccountTypeDropdownHandler() {
  $("select#account_type").on('change', function() {
    let val = $(this).val();
    let oemBrandOwner = $("#oem_c"),
        manufacturingTypeField = $('select#manufacturing_type_c'); // Yes or No
    
    if (val == 'OEMBrandOwner') {
      oemBrandOwner.val('Yes').trigger('change');
      manufacturingTypeField.val('Other').trigger('change');
    } else {
      oemBrandOwner.val('').trigger('change');
      manufacturingTypeField.val('').trigger('change');
    }

    //OnTrack #1485 - Account Priority set to A
    if(val == 'Prospect'){
      $('#account_class_c').val('A');
    }
    else{
      $('#account_class_c').val('');
    }
  });

  if($('input[name="record"]').val() == ""){
    $("select#account_type").change();
  }
}

function filterCountryJsonList(jsonList, filterBy, filterValue, equalTo = true) {
  if (equalTo) {
    var dropdwonList = jsonList.filter(function(data) {
      if (filterBy == 'country_code') {
        return (data['country_code'] == filterValue || data['country_code_3'] == filterValue) && data['type'] != 'country';
      } else {
        return data[filterBy].toLowerCase() == filterValue;
      }
    }).map(function(item) {
        var obj = {};
        obj.label = item['name'];
        obj.value = item['3166_code'];
  
        return obj;
    });

  } else {
    
    var dropdwonList = jsonList.filter(function(data) {
      if (filterBy == 'country_code') {
        return (data['country_code'] == filterValue || data['country_code_3'] == filterValue) && data['type'] != 'country';
      } else {
        return data[filterBy] != filterValue;
      }
    }).map(function(item) {
        var obj = {};
        obj.label = item['name'];
        obj.value = item['3166_code'];
  
        return obj;
    }).sort(function(row1, row2) {
      return row1.label.localeCompare(row2.label);
    });
    
  }
  return dropdwonList;
}

function customValidateCurrencyField(formname, fieldname, label)
{
    min = 0;
    max = 999999999.99;
    formname = formname || 'EditView';
    fieldname = fieldname || 'annual_revenue_potential_c'
    label = ($("div[data-label='LBL_ANNUAL_REVENUE_POTENTIAL']").html() != undefined) 
        ? $("div[data-label='LBL_ANNUAL_REVENUE_POTENTIAL']").html().trim().replace(/:/g, '')
        : label;

    addToValidate(formname, fieldname, 'currency', true, label);

    fieldname2 = 'annual_revenue'
    label2 = $("div[data-label='LBL_ANNUAL_REVENUE']").html().trim().replace(/:/g, '');

    addToValidate(formname, fieldname2, 'currency', true, label2);

    validate[formname][validate[formname].length-1][jstypeIndex] = 'range';
    validate[formname][validate[formname].length-1][minIndex] = min;
    validate[formname][validate[formname].length-1][maxIndex] = max;
}