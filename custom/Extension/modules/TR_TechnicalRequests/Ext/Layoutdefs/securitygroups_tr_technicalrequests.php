<?php
 // created: 2019-10-14 13:17:27
$layout_defs["TR_TechnicalRequests"]["subpanel_setup"]['securitygroups_tr_technicalrequests'] = array (
  'order' => 100,
  'module' => 'SecurityGroups',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITY_GROUPS_TECHNICAL_REQUEST_TITLE',
  'get_subpanel_data' => 'SecurityGroups',
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