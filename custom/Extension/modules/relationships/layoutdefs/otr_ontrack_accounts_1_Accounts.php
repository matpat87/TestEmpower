<?php
 // created: 2018-08-11 09:34:09
$layout_defs["Accounts"]["subpanel_setup"]['otr_ontrack_accounts_1'] = array (
  'order' => 100,
  'module' => 'OTR_OnTrack',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_OTR_ONTRACK_ACCOUNTS_1_FROM_OTR_ONTRACK_TITLE',
  'get_subpanel_data' => 'otr_ontrack_accounts_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
