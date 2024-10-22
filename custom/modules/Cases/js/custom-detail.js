$(document).ready(function(){
    var beanId = $('input[name="record"]').val();

    if (beanId) {
        // Deprecated feature in OnTrack 1259 -- replaced button to a dropdown field
        $('#verified_status_c_btn').on('click', function(e) {
            var newVal = $('#verified_status_c').val() != 1 ? 0 : 1;
            handleVerificationStatus(beanId, newVal);
        });
    }
});
// Deprecated feature in OnTrack 1259 -- replaced button to a dropdown field
function handleVerificationStatus(customerIssueID, newVal) {


    var postData = { "id": customerIssueID, "value": newVal };
    // console.log(postData)
    $.ajax({
        type: "POST",
        url: "index.php?module=Cases&action=set_verification_status&to_pdf=1",
        data: postData,
        dataType: 'json',
        beforeSend: function() {
            $("input#verified_status_c_btn").val('Loading...');
        },
        success: function(jsonResult){
            if (jsonResult.success) {
                console.log(jsonResult);
                var statusText = jsonResult.is_verified == 1 ? 'Verified' : 'Unverified',
                    buttonText = jsonResult.is_verified == 1 ? 'Unverify' : 'Verify';
                $('#status-text').text(statusText);
                $("input#verified_status_c_btn").val(buttonText);
                $("input[name=verified_status_c]").val(jsonResult.is_verified);
            }
        },
        error: function(result){
            console.log('on error: ',result.error);
        }
    });
}