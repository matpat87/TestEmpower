$(document).ready(function() {
  let applicationVal = $('select[name="application_c"]').val();
  let projectTaskID = $("input[name='record']").val();
  
  $('div[data-id=LBL_EDITVIEW_PANEL3]').parents('div.panel-default').css('display', 'none');  // initially hide Time Subpanel

  $('#custom_add_time_non_db').on('change', function() {
    var addTime = $(this).val();
    
    let fieldsToValidate = [
      { name: 'work_performed_non_db', type: 'name', label: 'Work Performed'}, 
      { name: 'date_worked_non_db', type: 'date', label: 'Date Worked'}, 
      { name: 'time_non_db', type: 'float', label: 'Time'}, 
  ];

    if ($(this).is(':checked')) {
      // show time subpanel and log time
      $('div[data-id=LBL_EDITVIEW_PANEL3]').parents('div.panel-default').css('display', 'block');
      
      $.each(fieldsToValidate, function(index, field) {
        addToValidate('EditView', field.name, field.type, true, field.label);

        let divField = $(`div[field='${field.name}']`).prev();
        let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
        divField.text(divFieldNewLabel).append('<span class="required">*</span>');
    });
    } else {
      // hide time subpanel
      $('div[data-id=LBL_EDITVIEW_PANEL3]').parents('div.panel-default').css('display', 'none');
      
      $.each(fieldsToValidate, function(index, field) {
        removeFromValidate('EditView', field.name);
        
        let divField = $(`div[field='${field.name}']`).prev();
        let divFieldNewLabel = divField.text().trim().replaceAll('*', '');
        divField.text(divFieldNewLabel);

        $(`#${field.name}`).removeAttr('style').parent().find('.required.validation-message').css('display', 'none');
      });
    }
  });

  getReleaseDropdwonAjax(projectTaskID, applicationVal);

  $("input#date_finish").prop('readonly', true); // disable input for Closed Date field

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
        $("input#date_finish").val(today);

      } else {
        $("input#date_finish").val(null);
      }
   
  });

  $('select[name="application_c"]').on('change', function() {
    var appValue = $(this).val();
    
    if (appValue != "") {
      getReleaseDropdwonAjax(null, appValue);
    }

  });


  function getReleaseDropdwonAjax(projectTaskID,  applicationID) {
   
    var payload = {
      'application_id': applicationID,
      'project_task_id': projectTaskID
    };

    $.ajax({
      type: "GET",
      url: "index.php?module=ProjectTask&action=get_release_dropdown&to_pdf=1",
      data: payload,
      success: function(result) {
        var jsonData = $.parseJSON(result);
        if (result) {
          $('select[name="phase_c"]').html(jsonData.data);
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  }
  
});