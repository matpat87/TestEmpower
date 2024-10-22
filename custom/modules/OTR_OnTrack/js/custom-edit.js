$(document).ready(function() {
  $('div[data-id=LBL_EDITVIEW_PANEL2]').parents('div.panel-default').addClass('hidden');  // initially hide Time Subpanel

  $("input#closed_date_c").prop('readonly','readonly'); // disable input for Closed Date field

  $('select[name="status"]').on("change", function() {
    var newStatusID = $(this).val(),
        newStatusText = $(this).children('option:selected').text();

      // Fill date now on Status Change to "Closed"
      if (newStatusText.indexOf("Closed") > 1) {
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = (month) + "/" + (day) + "/"+ now.getFullYear();

        $('#datePicker').val(today);
        $("input#closed_date_c").val(today);

      } else {
        $("input#closed_date_c").val(null);
      }
   
  });
  
  $('#add_time_non_db').on('change', function() {
    var addTime = $(this).val();
    
    let fieldsToValidate = [
      { name: 'work_performed_non_db', type: 'name', label: 'Work Performed'}, 
      { name: 'date_worked_non_db', type: 'date', label: 'Date Worked'}, 
      { name: 'time_non_db', type: 'float', label: 'Time'}, 
  ];

    if ($(this).is(':checked')) {
      // show time subpanel and log time
      $('div[data-id=LBL_EDITVIEW_PANEL2]').parents('div.panel-default').removeClass('hidden');
      
      $.each(fieldsToValidate, function(index, field) {
        addToValidate('EditView', field.name, field.type, true, field.label);

        let divField = $(`div[field='${field.name}']`).prev();
        let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
        divField.text(divFieldNewLabel).append('<span class="required">*</span>');

      });

      // Populate description field; Copy Status update
      let statusLog = jQuery("#status_update_c").val();
      jQuery("#work_description_non_db").val(statusLog);

    } else {
      // hide time subpanel
      $('div[data-id=LBL_EDITVIEW_PANEL2]').parents('div.panel-default').addClass('hidden');;
      
      $.each(fieldsToValidate, function(index, field) {
        removeFromValidate('EditView', field.name);
        
        let divField = $(`div[field='${field.name}']`).prev();
        let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
        divField.text(divFieldNewLabel);

        $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
      });
      jQuery("#work_description_non_db").val("");
    }
  });

});

function timeSubpanel() {
  // $('div[data-id=LBL_EDITVIEW_PANEL2]')
}