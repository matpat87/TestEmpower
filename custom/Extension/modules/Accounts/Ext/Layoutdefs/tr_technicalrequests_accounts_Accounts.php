<?php
 // created: 2019-02-11 17:33:48
$layout_defs["Accounts"]["subpanel_setup"]['tr_technicalrequests_accounts'] = array (
  'order' => 100,
  'module' => 'TR_TechnicalRequests',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_TR_TECHNICALREQUESTS_TITLE',
  'get_subpanel_data' => 'tr_technicalrequests_accounts',
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
