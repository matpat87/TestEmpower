//OnTrack #1301
var gblDefStatuses = [];
manageStatus();

$(document).ready(function(e){
    $('#approval_stage_advanced').on('click', function(){
        approvalStageClicked();
    });
});

function manageStatus(){
    gblDefStatuses = $('#status_advanced').val();

    $('#status_advanced option').remove();

    var approval_stage_advanced_val = $('#approval_stage_advanced').val();

    if(approval_stage_advanced_val != null){
        approvalStageClicked();
    }
}

function approvalStageClicked(e){
    var dropdown = $('#approval_stage_advanced');
    var stageVal = dropdown.val();
    var postData = { 'id': '', 'stage' : stageVal, 'is_submit_for_development': 'false', 'is_by_pass': 'true' };

    //alert(gblStatus);

    $.ajax({
        type: "POST",
        url: "index.php?module=TR_TechnicalRequests&action=get_status_dropdown&to_pdf=1",
        data: postData,
        dataType: 'json',
        success: function(result){
            if(result.success)
            {
                $('#status_advanced option').remove();

                $.each(result.data, function(index, item){
                    var option = '<option value="'+ item.key +'">'+ item.val +'</option>';
                    $('#status_advanced').append(option);
                });

                if(gblDefStatuses != null && gblDefStatuses.length > 0){
                    $.each(gblDefStatuses, function(index, item){
                        var status_advanced_option = $('#status_advanced option[value="'+ item +'"]');
                        status_advanced_option.attr('selected', 'selected');
                    });
                }
            }
        },
        complete: function(){
            
        },
        error: function(result){
            console.log(result);
            alert('error');
        }
    });
}