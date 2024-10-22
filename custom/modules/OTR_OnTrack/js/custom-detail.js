$(document).ready(function() {
    

    //     // Remove the event from the link
    //     this.onclick = null;
    //     $(this).on("click", function() {
    //         customRemoveBtnEvent();
    //         existing_event();
    //     });
        
    // });

    setInterval(function() {
        customizeRemoveBtn();
    }, 1000);
  
    // triggered when a time data is removed via subpanel REMOVE button
    // customizeRemoveBtn();
});

function customizeRemoveBtn() {
    // console.log("set interval")
    let timeSubmitBtn = $(document).find('a.listViewTdToolsS1[id^=otr_ontrack_time_remove_]:not([class~="custom-time-subpanel-remove-btn"])');
    // console.log(timeSubmitBtn);
    timeSubmitBtn.each(function(index) {
        $(this).removeAttr('onclick');

        if (!$(this).hasClass('custom-remove-btn')) {
            $(this)
                .addClass('custom-remove-btn')
                .on('click', function(e) {
                    e.preventDefault();
                    let actualHrsStr = parseFloat($('div[field=actual_hours_worked_c]').text().trim());
                    var hrefStringSplit = $(this).attr('href').split(",");
                    var timeID = hrefStringSplit[2].trim().replace(/['"]+/g, '');// to get the TIME ID for the current row
            
                    let isConfirmed = sp_rem_conf();
        
                    if (isConfirmed) {
                        console.log('triggering...');
                        $.ajax({
                            type: "GET",
                            url: "index.php?module=Time&action=get_time_data&to_pdf=1",
                            data: { 'time_id': timeID },
                            dataType: 'json',
                            success: function(result){
                                console.log('ajax: ', result);
                                console.log('actual hrs worked: ', actualHrsStr);
        
                                if (result.success) {
                                    var newActualHoursWorked = parseFloat(actualHrsStr).toFixed(2) - parseFloat(result.data.time).toFixed(2);
                                    $('div[field=actual_hours_worked_c] span#actual_hours_worked_c').text(newActualHoursWorked.toFixed(2).toString())
                                    console.log("new: ", newActualHoursWorked);
                                }
                                
                            },
                            error: function(result){
                                console.log(result);
                            
                            }
                        });
                        window.location.href = $(this).attr('href');
                        console.log('hello there');
                    }
                });
        }

    });

}