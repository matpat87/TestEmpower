jQuery( () => {
    handleTimePanelDisplay();
});

const handleTimePanelDisplay = () => {
    let status = $("#status").val();

    if (! ['complete', 'rejected'].includes(status)) {
        $('div[data-id=LBL_DETAILVIEW_PANEL1]').parents('div.panel-default').css('display', 'none');
    }
}