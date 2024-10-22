jQuery(function() {
    // checkRelatedAccountPriorityValue(); -- OnTrack 1698 Reverted behaviour as per request
   
});

const checkRelatedAccountPriorityValue = () => {
      let record_id = jQuery("input:hidden#record_id").val();

      jQuery.ajax({
        type: "GET",
        url: "index.php?module=Opportunities&action=retrieve_related_account_account_priority&to_pdf=1",
        data: { 'opp_id': record_id },
        dataType: 'json',
        error: function(result){
            console.log(result);
        }
      }).done((result) => {
        let {opp_rel_account: {id, account_priority}} = result;
        if (account_priority == 'D') {
          let interval = setInterval(() => {
            if (jQuery("#TR_TechnicalRequests_create_button:not(:hidden)").length > 0 && jQuery("#custom-text").length == 0) {
                handleTrSubpanelTopButtons();
                clearInterval(interval);
            }
          }, 100);
        }
      });

    
};

const handleTrSubpanelTopButtons = () => {
    
    jQuery('#list_subpanel_tr_technicalrequests_opportunities ul.SugarActionMenu').css({
      'width': '100%',
      'margin': '3px'
    });
    jQuery('#list_subpanel_tr_technicalrequests_opportunities li.sugar_action_button ').css({'width': 'initial'});

    jQuery('#list_subpanel_tr_technicalrequests_opportunities li.sugar_action_button')
      .parent()
      .append('<div id=\"custom-text\"><p>Technical Requests cannot be submitted for Customers with Account Priority: \"D\"</p></div>')
    jQuery('#custom-text').css({
      'font-weight': 'bold',
      'color': 'red'
    });
    jQuery('#list_subpanel_tr_technicalrequests_opportunities li.sugar_action_button').off('submit');
    jQuery('#list_subpanel_tr_technicalrequests_opportunities li.sugar_action_button span.suitepicon-action-caret').unbind('click');
    jQuery('#TR_TechnicalRequests_create_button')
      .off('click')
      .on('click', function() {
        alert('Technical Requests cannot be submitted for Customers with Account Priority: \"D\"')
    });
}