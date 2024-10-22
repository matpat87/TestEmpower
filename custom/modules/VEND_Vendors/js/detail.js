$(document).ready(function(){
    setNonDbFieldsTabDisplay();
});

function setNonDbFieldsTabDisplay() {
    let panel_bg_color = 'var(--custom-panel-bg)';

    $("div[field='marketing_information_non_db'],div[field='erp_data_non_db']")
        .prev()
        .removeClass('col-sm-2')
        .addClass('col-sm-12')
        .addClass('col-md-12')
        .addClass('col-lg-12')
        .css('background-color', panel_bg_color)
        .css('color', '#FFF')
        .css('margin-top', '15px');

    $("div[field='marketing_information_non_db']")
        .prev()
        .css('margin-top', '0px');

    $("div[field='marketing_information_non_db'],div[field='erp_data_non_db']")
        .addClass('hidden');
}