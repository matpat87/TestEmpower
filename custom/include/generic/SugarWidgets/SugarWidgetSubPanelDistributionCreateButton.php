<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

//class SugarWidgetSubPanelSendInvitesButton extends SugarWidgetSubPanelTopButton
class SugarWidgetSubPanelDistributionCreateButton extends SugarWidgetSubPanelTopButton
{
    function __construct($module='', $title='', $access_key='', $form_value='')
    {
        parent::__construct($module, $title, $access_key, $form_value);
    }

    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings, $app;

        $id = $app->controller->bean->id;

        $button .= '
        <form 
            action="index.php" 
            method="post" 
            name="form">
            <a 
                href="index.php?module=DSBTN_Distribution&action=EditView&parent_module=TR_TechnicalRequests&parent_id='. $id .'&return_module=TR_TechnicalRequests&return_id='. $id .'&return_action=DetailView&;return_relationship=get_distributions" 
                id="tr_technicalrequests_dsbtn_distributionitems_1_edit_1"
            >Create</a>
        </form>';
		
		return $button; 
    }
}

?>