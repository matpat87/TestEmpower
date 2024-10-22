jQuery(document).ready(function() {
    saveForm();
});

function saveForm() {
    $('#SAVE.button.primary')
        .removeAttr('onclick')
        .on('click', (event) => {
            event.preventDefault();
            console.log('custom submit');
            
            let customer_issue_id = jQuery('#cases_pa_preventiveactions_1cases_ida').val();
            
            triggerCustomerIssueStatusCheck(customer_issue_id).done(function(response) {
               let { status, ci_status_list } = JSON.parse(response);

                if (['CAPAApproved', 'CAPAComplete', 'Closed'].includes(status)) {
                    alert(`Unable to Save. Selected Customer Issue is already of status: ${ci_status_list[status]}`);
                } else {
                    let _form = document.getElementById('EditView');
                    _form.action.value = 'Save';
                    check_form('EditView') && SUGAR.ajaxUI.submitForm(_form);
                }
            });

        });
};

const triggerCustomerIssueStatusCheck = (customer_issue_id) => {
    
    return $.ajax({
        url: "index.php?module=PA_PreventiveActions&action=check_customerissue_status&to_pdf=1",
        type: "POST",
        data: { 'customer_issue_id': customer_issue_id },
        success: function(result){
            // console.log(result)
           
        },
        error: function(response) {
            console.log("error: ", response)
        } 
    }); 
}