jQuery(document).ready(function() {
   console.log('CUSTOM SCRIPT FOR CONVERTLEAD LAYOUT: custom/modules/Leads/js/custom-edit.js');

   $.getJSON('./custom/include/json/complete_country_list.json', function(data) {


      var fieldValues = {
        'primary_country': $("select#Contactsprimary_address_country").val(),
        'primary_state': $("select#Contactsprimary_address_state").val(),
      };
  
      countryChanged(data);
      stateDynamicDropdownList(fieldValues, null, data);
      // stateDynamicDropdownList(
      //       billingStateFieldValues,
      //       ".edit-view-field #billing_address_state",
      //       data
      //   );
    });

    // If Lead Config Copy/Move is set, have Contacts checked as defaul
    // No need to have Account to be selected together with Contacts as a Contact is already related to the Account, if we select both it causes an issue where it creates duplicate activities
    ($("#lead_conv_ac_op_sel").val() === null || $("#lead_conv_ac_op_sel").val().length <= 0) ? $("#lead_conv_ac_op_sel").val(['Contacts']) : '';

    // Hide Module selector for Activities inheritance to prevent user from selecting multiple modules
    $("#lead_conv_ac_op").css('visibility', 'hidden');
});

function countryChanged(countries) {

   $("select#Contactsprimary_address_country").on('change', function() {
      stateDynamicDropdownList({ 'primary_country': $(this).val()}, null, countries);
   });
 }

function stateDynamicDropdownList(fieldValues, childFieldStr, jsonList)
{
  childFieldStr = childFieldStr || "select#Contactsprimary_address_state";
  var stateDropdownList = filterCountryJsonList(jsonList, 'country_code', fieldValues.primary_country);
   
  resetDropdownList(childFieldStr, stateDropdownList ,fieldValues.primary_state);

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
       obj.label = item['name'];
       obj.value = item['3166_code'];
 
       return obj;
   });
 
   return dropdwonList;
 }