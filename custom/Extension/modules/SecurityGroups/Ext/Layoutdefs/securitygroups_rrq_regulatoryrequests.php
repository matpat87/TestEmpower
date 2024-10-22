<?php
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_rrq_regulatoryrequests'] = array (
  'order' => 100,
  'module' => 'RRQ_RegulatoryRequests',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_RRQ_REGULATORYREQUESTS_TITLE',
  'get_subpanel_data' => 'securitygroups_rrq_regulatoryrequests',
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
