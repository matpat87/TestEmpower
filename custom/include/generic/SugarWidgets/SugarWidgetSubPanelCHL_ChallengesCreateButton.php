<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

//class SugarWidgetSubPanelSendInvitesButton extends SugarWidgetSubPanelTopButton
class SugarWidgetSubPanelCHL_ChallengesCreateButton extends SugarWidgetSubPanelTopButton
{
    function __construct($module='', $title='', $access_key='', $form_value='')
    {
        parent::__construct($module, $title, $access_key, $form_value);
    }

    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings, $app;

        $id = $app->controller->bean->id;
        $name = $app->controller->bean->name;

		$button .= '<a href="index.php?module=CHL_Challenges&action=EditView&account_name='. $name .'&account_id='. $id .'&return_module=Accounts&return_id='. $id .'&return_action=DetailView&;" class="listViewTdToolsS1" style="height: 27px;padding: 0px 10px;">Create</a>';
        
		return $button; 
    }
}

?>