jQuery( () => {
    handleColormatchTypeDisplay();
    handleProductMasterRematch();
    handleTRActivities();
});

const handleColormatchTypeDisplay = () => {
    let type = $("#type");
    let typeVal = type.val();
    let colormatchTypeDiv = $("div[field='colormatch_type_c'");
    let acceptedTypeList = ['color_match', 'rematch', 'cost_analysis', 'ld_optimization', 'raw_material_evaluation'];
    let nameLabelHtml = $("div[field='name']").parent().find('.label').html();

    if (! acceptedTypeList.includes(type.val())) {
        colormatchTypeDiv.parent().hide()
        nameLabelHtml = type.val() ? nameLabelHtml.replace('Name', '#') : nameLabelHtml.replace('#', 'Name');
    } else {
        colormatchTypeDiv.parent().show();

        if (typeVal == 'color_match') {
            $("div[field='colormatch_type_c']").parent().find('.label').text('\nColormatch Type:\n');
        } else if (['rematch', 'cost_analysis', 'ld_optimization'].includes(typeVal)) {
            $("div[field='colormatch_type_c']").parent().find('.label').text('\nRematch Type:\n');
        } else if (typeVal == 'raw_material_evaluation') {
            $("div[field='colormatch_type_c']").parent().find('.label').text('\nRaw Material Type:\n');
        }

        if (['rematch', 'cost_analysis', 'ld_optimization'].includes(typeVal)) {
            nameLabelHtml = nameLabelHtml.replace('Name', '#');
        }
    }

    $("div[field='name']").parent().find('.label').html(nameLabelHtml);
}

const handleProductMasterRematch = () => {
    let typeVal = $("#type").val();
    let rematchTypeVal = $("#colormatch_type_c").val();
    let trId = $("input[name='record'][type='hidden']").val();
    let productRematchForm;
    let acceptedTypeList = ['rematch', 'cost_analysis', 'ld_optimization'];
    let acceptedRematchTypeList = ['product_master', 'product_version'];

    if (acceptedTypeList.includes(typeVal) && acceptedRematchTypeList.includes(rematchTypeVal)) {
        let productMasterInput = `
            <form action="index.php" method="POST" name="EditView" id="EditView" enctype="multipart/form-data" encoding="multipart/form-data" title="Use Popup to Set Value" style="display: none;">
                <input type='hidden' name='product_rematch_id' id='product_rematch_id'  maxlength='50' value=''>
            </form>
        `;

        let productMasterPopup = `
            <button type="button" id="product_popup" class="btn btn-sm btn-default" style="width: auto; height: 26px; margin-left: 5px; display: none;">
                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true" style="transform: rotate(40deg)"></span>
            </button>`;
        
        if (rematchTypeVal == 'product_master') {
            productRematchForm = `
            <form action="index.php?module=AOS_Products&action=EditView&return_module=AOS_Products&return_action=DetailView" method="POST" name="CustomForm" id="product_rematch_form" style="display: none;">
                <input type="hidden" name="is_rematch" id="is_rematch_product" value="true">
                <input type="hidden" name="product_id" id="product_id" value="">
                <input type="hidden" name="tr_id" id="tr_id" value="${trId}">
                <input type="submit" name="rematch" id="rematch_product" title="Rematch Product" class="button"  value="Rematch Product">
            </form>`;
        }    

        if (rematchTypeVal == 'product_version') {
            productRematchForm = `
            <form action="index.php?module=AOS_Products&action=EditView&return_module=AOS_Products&return_action=DetailView" method="POST" name="CustomForm" id="product_rematch_form" style="display: none;">
                <input type="hidden" name="is_rematch" id="is_rematch_version" value="true">
                <input type="hidden" name="product_id" id="product_id" value="">
                <input type="hidden" name="tr_id" id="tr_id" value="${trId}">
                <input type="submit" name="rematch" id="rematch_version" title="Rematch Version" class="button"  value="Rematch Version">
            </form>`;
        }

        let interval = setInterval(() => {
            if ($("#AOS_Products_create_button:not(:hidden)").length > 0) {
                $("#AOS_Products_create_button")
                    .css('margin-left', '0px')
                    .text('Rematch')
                    .off('click')
                    .on('click', () => {
                        $("#product_popup").trigger('click');
                    })
                    .closest('ul')
                    .append(productMasterInput)
                    .append(productMasterPopup)
                    .append(productRematchForm)
                    .find('li')
                    .removeClass('sugar_action_button')
                    .addClass('single')
                    .find('span.suitepicon')
                    .css('display', 'none')
                
                handleProductMasterPopUpClicked();
                monitorProductIdChange();
                clearInterval(interval);
            }
        }, 100);
    }
}

const handleProductMasterPopUpClicked = () => {
    let productNumber = $("#name > a").text().trim();

    $("#product_popup").on('click', () => {
        open_popup(
            "AOS_Products", 
            600, 
            400, 
            `&product_number_c_advanced=${productNumber}&filter_production_only_results=true`, 
            true, 
            false, 
            {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"product_rematch_id"}}, 
            "single", 
            true
        );
    })
}

// Hide button once Product Master is selected to prevent user from selecting multiple records
// Note: This function is also being used by SugarWidgetSubPanelTopSelectProductMasterButton
function set_return_and_save_background_and_hide_button(popupReplyData) {
    set_return_and_save_background(popupReplyData);
    $("#AOS_Products_create_button").closest('.sugar_action_button').css('display', 'none');
}

const monitorProductIdChange = () => {
    setInterval(() => {
        let productRematchId = $("#product_rematch_id").val();
        if (productRematchId && productRematchId.length > 0) {
            $("#product_rematch_form").find("#product_id").val(productRematchId);
            $("#product_rematch_form").find("input[type='submit']").trigger('click');
            $("#product_rematch_id").val('');
        }    
    }, 400);
}

//OnTrack #1293 - default Activity to TR Name
const handleTRActivities = () => {    
    var isActive = false;

    setInterval(() => {
        var subpanelForms = ['form_SubpanelQuickCreate_Calls', 'form_SubpanelQuickCreate_Tasks', 
            'form_SubpanelQuickCreate_Meetings'];

        for(var i = 0; i < subpanelForms.length; i++){
            var actSubpanelForm = $('#' + subpanelForms[i]);

            if(actSubpanelForm.length){
                if(!isActive){
                    var txtNameObj = actSubpanelForm.find('#name');
                    var trName = $('.detail-view').find('#name').text();
                    txtNameObj.val(trName);
                    isActive = true;
                }
            }
            else{
                isActive = false;
            }
        }
    }, 400);
}