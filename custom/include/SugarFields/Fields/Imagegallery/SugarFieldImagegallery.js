// Add New FileInput Row

function addRow(field_name, module) {
    var gallery_id = "gal_" + field_name;
    var base_row = "base_row_" + field_name;
    var count = $('#' + gallery_id).find('.gallery-image-' + field_name).length;
    var clone = $('#' + base_row).clone().removeClass('hidden').attr('id', '');

    var gallery_image_class = 'gallery-image-' + field_name;
    var gallery_image_tag_class = 'gallery-image-tag-' + field_name;

    $(clone).find('.form-control').each(function (index, inp) {
        switch (index) {
            case 0: // file upload input
                $(inp).attr('name', field_name + '[' + count + ']');
                $(inp).addClass(gallery_image_class);
                break;
            case 1: // hidden id
                $(inp).attr('name', field_name + '_id[' + count + ']');
                break;
            case 2: // loading
                $(inp).attr('id', field_name + '_loading_' + count + '');
                break;
            case 3:// text
                $(inp).attr('id', field_name + '_link_' + count + '');
                break;
            case 4:// tag element
                $(inp).attr('name', field_name + '_tag[' + count + ']');
                $(inp).addClass(gallery_image_tag_class);
                break;
            default:
                console.log('Default Condition: Error : more html elements in base row');
                break;
        }
    });
    // Append clone as the last child of main
    $('#' + gallery_id).append(clone);
    //Reindex the field names for part number and qty after add
    reindex(field_name, gallery_id);
}

function removeRow(element) {
    var file_id = $(element).data('file-id');
    var user_id = $(element).data('user-id');

    if (file_id != '') {
        if (confirm("Are you sure you want to Remove this Image")) {
            removeImage(file_id, user_id);
        }
        else return false;
    }

    $(element).closest("div.parent").remove();
    //Reindex the field names for partnumber and qty after Remove
    reindex($(element).data('field'), $(element).data('gallery'));
}

function reindex(field_name, gallery_id) {
    $('#' + gallery_id + ' .parent:not(.hidden)').each(function (i, element) {
        $(this).find('.form-control').each(function (index, item) {
            switch (index) {
                case 0:
                    $(item).attr('name', field_name + '[' + i + ']');
                    break;
                case 1:
                    $(item).attr('name', field_name + '_id[' + i + ']');
                    break;
                case 2:
                    $(item).attr('id', field_name + '_loading_' + i + '');
                    break;
                case 3:
                    $(item).attr('id', field_name + '_link_' + i + '');
                    break;
                case 4:
                    $(item).attr('name', field_name + '_tag[' + i + ']');
                    break;
                default:
                    console.log("ReIndex Default Cond");
                    break;
            }
        });
    });
}

// Remove FileInput
function removeImage(field_id, user_id) {
    var data = new FormData(); // Creating object of FormData class
    data.append('delete', 'true');
    data.append('field_id', field_id);
    data.append('user_id', user_id);

    $.ajax({
        url: "gallery_upload.php",
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            console.log(data);
        },
        error: function () {
            console.log("An error occured while deleting this file.");
            return false;
        }
    });
}

//Upload File to Server

function galleryChanged(element, field_id, record_id, module, current_user) {
    // Files List

    var allowedExt = new Array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tif', 'tiff');
    var fileUpload = element.files[0];
    var mystrr = new Array();
    var fileName = fileUpload.name.split(".");
    var extension = (fileName[fileName.length - 1]).toLowerCase();
    var isAllowed = allowedExt.indexOf(extension);

    if (isAllowed > -1) {
        if (fileUpload !== undefined)
            mystrr.push(fileUpload.name);
    }
    else {
        alert("File extension ." + extension + " is not allowed.");
        //Remove this from Files and correct Length
        return false;
    }

    // Update Files Name
    var form_data = new FormData(); // Creating object of FormData class
    // File Field ID
    form_data.append("file_input_id", field_id);
    // Record ID
    form_data.append("record_id", record_id);
    // Module
    form_data.append("module", module);

    form_data.append("current_user", current_user);

    form_data.append("fileToUpload[]", fileUpload);

    $(element).hide();
    $(element).next().next().removeClass('hidden');//show loader

    // Send Upload Call
    $.ajax({
        url: "gallery_upload.php",
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            var data = JSON.parse(response);
            // log msg for successfully uploading image
            if (data.status) {
                $(element).next().val(data.id); // set hidden element value
                $(element).next().next().hide();//hide loader
                $(element).next().next().next().removeClass('hidden').html(fileUpload.name);// show link of image

                // Update remove Button with record ID
                $(element).closest('.parent').find('.email-address-remove-button').attr('data-file-id', data.id);
                $(element).closest('.parent').find('.email-address-remove-button').attr('data-user-id', current_user);
            }
            else {// uploaded file name already exists at destination
                alert(data.msg);

                $(element).show();
                $(element).val('');
                $(element).next().next().hide();//hide loader
            }
        },
        error: function () {
            alert("An error occured while uploading files. Please make sure the upload path is writable and try again.");
            return false;
        }
    });

} // File Change Ftn
