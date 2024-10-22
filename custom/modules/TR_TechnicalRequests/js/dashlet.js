$('.dashletPanel-tr-custom').ready(function(e){
    var tblDashlet = $('.dashletPanel-tr-custom'); 
    var dashletPanel = tblDashlet.parents('.dashletPanel');
    var editLink = dashletPanel.find('.dashletToolSet > a:first');

    editLink.on('click', function(e){
        var intrvlApprovalStage = setInterval(function(){
            if($("select[name='approval_stage[]']").length){
                clearInterval(intrvlApprovalStage);

                $("select[name^='approval_stage'").on('change', StageChanged);
                StageChanged();
            }            
        }, 500);
    });

});

function StageChanged(e){
    var approvalStageObj = $("select[name^='approval_stage'");
    var statusObj = $("select[name^='status'");
    var statusesSelected = [];
    var i = 0;
    $.each(statusObj.find('option:selected'), function(index, item){
        statusesSelected[i] = $(item).attr('value');
        i++;
    });
    statusObj.find('option').remove(); //clear statuses
    var postData = { 'stage' : approvalStageObj.val() };

    $.ajax({
        type: "POST",
        url: "index.php?module=TR_TechnicalRequests&action=get_status_dropdown&to_pdf=1",
        data: postData,
        dataType: 'json',
        success: function(result){
            if(result.success)
            {
                //console.log('success');
                statusObj.find('option').remove();

                $.each(result.data, function(index, item){
                    var isSelected = (statusesSelected.indexOf(item.key) != -1);
                    var option = new Option(item.val, item.key, isSelected, isSelected);
                    statusObj.append(option);
                    //console.log('added');
                });
            }
        },
        complete: function(){
            
        },
        error: function(result){
            console.log(result);
            alert('Something went wrong while processing your request. Please try again later.');
        }
    });
}