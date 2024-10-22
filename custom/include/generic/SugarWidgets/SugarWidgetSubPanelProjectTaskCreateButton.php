<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

//class SugarWidgetSubPanelSendInvitesButton extends SugarWidgetSubPanelTopButton
class SugarWidgetSubPanelProjectTaskCreateButton extends SugarWidgetSubPanelTopButton
{
    function __construct($module='', $title='', $access_key='', $form_value='')
    {
        parent::__construct($module, $title, $access_key, $form_value);
    }

    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings, $app;

        $id = $app->controller->bean->id;
        $moduleName = $app->controller->bean->module_dir;

		$button .= '<form><a href="index.php?module=ProjectTask&action=EditView&parent_module='. $moduleName .'&parent_id='. $id .'&parent_type='. $moduleName .'&return_module='. $moduleName .'&return_id='. $id .'&return_action=DetailView&;return_relationship=get_distributions">Create</a></form>';
        
		return $button; 
    }
}

?>