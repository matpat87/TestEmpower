<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

//class SugarWidgetSubPanelSendInvitesButton extends SugarWidgetSubPanelTopButton
class SugarWidgetSubPanelTRItemCreateButton extends SugarWidgetSubPanelTopButton
{
    function __construct($module='', $title='', $access_key='', $form_value='')
    {
        parent::__construct($module, $title, $access_key, $form_value);
    }

    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings, $app;

        $id = $app->controller->bean->id;
        return "<form><a href='index.php?module=TRI_TechnicalRequestItems&action=EditView&tri_techni0387equests_ida={$id}&return_module=TR_TechnicalRequests&return_id={$id}&return_action=DetailView'>Create</a></form>";
    }
}

?>