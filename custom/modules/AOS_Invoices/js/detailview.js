$('div[field="total_amt"]').parents('.detail-view-row').find('.clear').remove();
$('div[field="total_discount_c"]').parents('.detail-view-row').find('.clear').remove();
$('div[field="subtotal_amount"]').parents('.detail-view-row').find('.clear').remove();
$('div[field="misc_c"]').parents('.detail-view-row').find('.clear').remove();
$('div[field="freight_c"]').parents('.detail-view-row').find('.clear').remove();
$('div[field="tax_amount"]').parents('.detail-view-row').find('.clear').remove();
$('div[field="total_amount"]').parents('.detail-view-row').find('.clear').remove();

const showAdditionalInfo = (id) => {
    jQuery.ajax({
        type: 'GET',
        url: 'index.php?module=AOS_Invoices&action=retrieve_additional_details&to_pdf=1',
        dataType: 'json',
        data: { line_item_id: id }
    }).done(function(responseData) {
        let html = '';
        let decodedResponseData = JSON.parse(responseData);
        let shippingDetails = decodedResponseData?.shipping_details;
        let lots = decodedResponseData?.lots;

        if (shippingDetails?.length > 0 || lots?.length > 0) {
            if (shippingDetails?.length > 0) {
                html += `<h6 style="font-weight: bold; margin: 3px 0px; border-bottom: 1px solid black; padding-bottom: 3px;">Shipping Details</h6>`;
    
                shippingDetails.forEach((shippingDetail) => {
                    Object.values(shippingDetail).forEach((data) => {
                        html += `<p style="margin: 0px; font-size: 12px;"><span style="font-weight: bold;">${data?.label}</span>: ${data?.value}</p>`;
                    });
    
                    html += `<br>`;
                });
            }
            
            if (lots?.length > 0) {
                html += `<h6 style="font-weight: bold; margin: 3px 0px; border-bottom: 1px solid black; padding-bottom: 3px;">Lots</h6>`;
    
                lots.forEach((lot) => {
                    Object.values(lot).forEach((data) => {
                        html += `<p style="margin: 0px; font-size: 12px;"><span style="font-weight: bold;">${data?.label}</span>: ${data?.value}</p>`;
                    });
                });
            }
        } else {
            html += `<h6 style="font-weight: bold; margin: 3px 0px;">No Shipping Details/Lot Information Available</h6>`;
        }
        
        handleShowAdditionalDetailsDialogBox(id, html);
    });
}

// Need to declare globally to allow only one open dialog box at a time
let dialogBox = jQuery('<div class="open"></div>');

const handleShowAdditionalDetailsDialogBox = (id, html) => {
    let el = `#adspan_${id}`;

    dialogBox
        .html(html)
        .dialog( {
            autoOpen: false,
            title: 'Additional Details',
            width: 300,
            draggable: false,
            position: {
                my: 'right top',
                at: 'left top',
                of: $(el)
            }
        });

    let width = dialogBox.dialog("option", "width");
    let pos = jQuery(el).offset();
    let ofWidth = jQuery(el).width();

    if ((pos.left + ofWidth) - 40 < width) {
        dialogBox.dialog("option", "position", {my: 'left top', at: 'right top', of: jQuery(el)});
    }
    
    jQuery(".ui-dialog").appendTo("#content");
    dialogBox.dialog('open');
}