<?php
 // created: 2020-11-18 07:09:58
$layout_defs["CI_CustomerItems"]["subpanel_setup"]['securitygroups_ci_customeritems'] = array (
  'order' => 100,
  'module' => 'SecurityGroups',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_CI_CUSTOMERITEMS_FROM_SECURITYGROUPS_TITLE',
  'get_subpanel_data' => 'securitygroups_ci_customeritems',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
