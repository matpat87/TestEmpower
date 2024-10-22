const toggleManagementUpdateModal = (e) => {
    
    let moduleName = jQuery(e.currentTarget).attr('activity-name');
    let recordId = jQuery(e.currentTarget).attr('data-id');
    let subject = jQuery(e.currentTarget).attr('activity-subject');
    let status = jQuery(e.currentTarget).attr('activity-status');
   
    
    retrieveModuleDetails(response => {
        const { data } = response;
        // console.log(data)
        let modaltitle = `${status} - ${subject}`;
        jQuery('.modal-title').text(modaltitle);
        jQuery('#management_update').text(data.management_update_c);
        jQuery('input[name=activity_module]').val(moduleName);
        jQuery('input[name=record_id]').val(data.id);
        jQuery('#management-update-modal').modal('toggle');

    }, moduleName, recordId);

}

const retrieveModuleDetails = (callback, moduleName, recordId) => {

    jQuery.ajax({
        url: "index.php?module=SAR_SalesActivityReport&action=get_module_data&to_pdf=1",
        type: "GET",
        dataType: 'json',
        data: {
            'activityModuleName': moduleName,
            'activityModuleId': recordId
        },
        success: function(response) {
            
            if (typeof callback === 'function') {
                callback(response)
            }
        }
    });

    return false;
}

const saveManagementUpdate = (e) => {
    e.preventDefault();
    let managementUpdate =jQuery('#management_update').val();
    let moduleName =  jQuery('input[name=activity_module]').val();
    let record = jQuery('input[name=record_id]').val();

    const formData = new FormData();
    formData.append('record', record);
    formData.append('module_name', moduleName);
    formData.append('management_update', managementUpdate);
    
    $.ajax({
        url: "index.php?module=SAR_SalesActivityReport&action=save_module_data&to_pdf=1",
        type: "POST",
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        success: function (response) {
            // console.log(response);
            jQuery('#management-update-modal').modal('toggle');
        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    }).done(function(res) {
        location.reload();
    });
}

jQuery(function() {
    jQuery(".management-update-btn").on('click', toggleManagementUpdateModal);
    jQuery("#sar_management_update_submit").on('click', saveManagementUpdate);
});