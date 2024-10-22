

$(document).ready(function() {
    var fieldValues = {
        record_id: $("input[name='record'][type='hidden']").val(),
        parent_type: $("select#parent_type").val(),
        parent_id: $("input#parent_id[type='hidden']").val()
    } 
    
    disableParentFields()
    
    setInterval(function(){
        parentChangeChecker(fieldValues);
    }, 300)
});

function retrieveParentData(obj) {
    $.ajax({
        type: "GET",
        url: "index.php?module=CWG_CAPAWorkingGroup&action=get_parent_data&to_pdf=1",
        data: obj,
        dataType: 'json',
        success: function(response){
            console.log(response)

            if (response.success) {
                fillFormValues(response.data);
            }
        }
    });
}

function parentChangeChecker(fieldValues) {
    var isChanged = fieldValues.parent_id != $("input#parent_id[type='hidden']").val() ? true : false;

    if (isChanged) {
        fieldValues.parent_id = $("input#parent_id[type='hidden']").val();
        fieldValues.parent_type = $("select#parent_type").val();
        retrieveParentData(fieldValues);
    }
}

function fillFormValues(data) {
    $("#first_name_non_db").val(data.first_name)
    $("#last_name_non_db").val(data.last_name)
    $("#phone_work_non_db").val(data.phone_work)
    $("#phone_mobile_non_db").val(data.phone_mobile)
    $("#company_non_db").val(data.company)
    $("#email_address_non_db").val(data.email)
}

function disableParentFields() {
    $("#first_name_non_db").prop('disabled', true);
    $("#last_name_non_db").prop('disabled', true);
    $("#phone_work_non_db").prop('disabled', true);
    $("#phone_mobile_non_db").prop('disabled', true);
    $("#company_non_db").prop('disabled', true);
    $("#email_address_non_db").prop('disabled', true);
}