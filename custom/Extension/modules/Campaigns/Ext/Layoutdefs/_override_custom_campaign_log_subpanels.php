<?php
$layout_defs['Campaigns']['subpanel_setup']['targeted']['top_buttons'] = array (
    array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
    array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
);

$layout_defs['Campaigns']['subpanel_setup']['viewed']['top_buttons'] = array (
    array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
    array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
);

$layout_defs['Campaigns']['subpanel_setup']['link']['top_buttons'] = array (
    array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
    array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
);

$layout_defs['Campaigns']['subpanel_setup']['invalid_email']['top_buttons'] = array (
    array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
    array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
);

$layout_defs['Campaigns']['subpanel_setup']['send_error']['top_buttons'] = array (
    array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
    array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
);

$layout_defs['Campaigns']['subpanel_setup']['blocked']['top_buttons'] = array (
    array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
    array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
);

$layout_defs['Campaigns']['subpanel_setup']['not_viewed'] = array(
    'order' => 121,
    'module' => 'CampaignLog',
    'get_subpanel_data' => "function:track_log_entries",
    'subpanel_name' => 'default',
    'function_parameters' => array(0 => 'targeted', 1 => 'viewed', 'EMAIL_MARKETING_ID_VALUE' => '',/*'group_by'=>'campaign_log.target_id','distinct'=>'campaign_log.target_id'*/),
    'title_key' => 'LBL_LOG_ENTRIES_NOT_VIEWED_TITLE',
    'sort_order' => 'desc',
    'sort_by' => 'campaign_log.id',
    'top_buttons' => array (
        array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
        array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
    ),
);

$layout_defs['Campaigns']['subpanel_setup']['not_link'] = array(
    'order' => 131,
    'module' => 'CampaignLog',
    'get_subpanel_data' => "function:track_log_entries",
    'function_parameters' => array(0 => 'targeted', 1 => 'link', 'EMAIL_MARKETING_ID_VALUE' => '',/*'group_by'=>'campaign_log.target_id','distinct'=>'campaign_log.target_id'*/),
    'subpanel_name' => 'default',
    'title_key' => 'LBL_LOG_ENTRIES_NOT_LINK_TITLE',
    'sort_order' => 'desc',
    'sort_by' => 'campaign_log.id',
    'top_buttons' => array (
        array('widget_class' => 'SubPanelAddToProspectListButton','create'=>'true'),
        array('widget_class' => 'SubPanelExportCampaignLogToExcelButton'),
    ),
);