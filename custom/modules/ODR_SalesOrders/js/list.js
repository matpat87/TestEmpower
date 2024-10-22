var $dialog = $('<div class="open"></div>');

function showAdditionalInfo(id, ship_date_resin_code, req_ship_date_orig){
    var html = '<h6 style="font-weight: bold; margin: 0px;">Required Ship Date - Reason Code</h6>';
    html += '<h6 style="margin: 0px;">' + ship_date_resin_code + '</h6><br/>';
    html += '<h6 style="font-weight: bold; margin: 0px;">Required Ship Date - Original</h6>';
    html += '<h6 style="margin: 0px;">' + req_ship_date_orig + '</h6><br/>';
    
    var el = '#' + id;
    $dialog.html(html)
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

    var width = $dialog.dialog("option", "width");
    var pos = $(el).offset();
    var ofWidth = $(el).width();

    if ((pos.left + ofWidth) - 40 < width) {
        $dialog.dialog("option", "position", {my: 'left top', at: 'right top', of: $(el)});
    }
        
    $(".ui-dialog").appendTo("#content");
    $dialog.dialog('open');
}