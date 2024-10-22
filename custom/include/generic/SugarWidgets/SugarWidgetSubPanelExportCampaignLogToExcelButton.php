<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

class SugarWidgetSubPanelExportCampaignLogToExcelButton extends SugarWidgetSubPanelTopButton
{
    public function __construct($module='', $title='', $access_key='', $form_value='')
    {
        parent::__construct($module, $title, $access_key, $form_value);
    }

    public function display($defines, $additionalFormFields = null, $nonbutton = false)
    {
        global $app;

        $bean = $app->controller->bean;
        $campaignId = $bean->id;
        $campaignType = $defines['subpanel_definition']->_instance_properties['function_parameters'][0];
        $campaignMarketingId = $defines['subpanel_definition']->_instance_properties['function_parameters']['EMAIL_MARKETING_ID_VALUE'];
        $subpanelTitleKey = $defines['subpanel_definition']->_instance_properties['title_key'];

        $campaignSubTypeParameter = '';

        if (isset($defines['subpanel_definition']->_instance_properties['function_parameters'][1])) {
            $campaignSubType = $defines['subpanel_definition']->_instance_properties['function_parameters'][1];
            $campaignSubTypeParameter = "&campaign_sub_type={$campaignSubType}";
        }

        return "<a href='index.php?entryPoint=CampaignLogExportExcel&campaignId={$campaignId}&campaign_type={$campaignType}{$campaignSubTypeParameter}&campaign_marketing_id={$campaignMarketingId}&subpanelTitleKey={$subpanelTitleKey}'>Export to Excel</a>";
    }
}
