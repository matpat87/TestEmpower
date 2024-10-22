<?php
 // created: 2020-12-04 15:53:46
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_dsbtn_distribution'] = array (
  'order' => 100,
  'module' => 'DSBTN_Distribution',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_DSBTN_DISTRIBUTION_TITLE',
  'get_subpanel_data' => 'securitygroups_dsbtn_distribution',
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
