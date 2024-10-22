<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

//class SugarWidgetSubPanelSendInvitesButton extends SugarWidgetSubPanelTopButton
class SugarWidgetSubPanelCustomerProductsSelectButton extends SugarWidgetSubPanelTopButton
{
    function __construct($module='', $title='', $access_key='', $form_value='')
    {
        parent::__construct($module, $title, $access_key, $form_value);
    }

    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings, $app, $sugar_config;

        $id = $app->controller->bean->id;
        $name = $app->controller->bean->name;

        // Ontrack 1791: styling customize if in case its in QA branch or in prod
        $btnPadding = $sugar_config['isQA'] == true ? 'padding-left:1rem;' : 'padding-left:2rem;';

		$button .= '<a style="'.$btnPadding.'" href="index.php?entryPoint=ExportRrCustomerProducts&regulatory_request_id='. $id .'" target="_blank">Export</a>';
        
		return $button; 
    }
}

?>