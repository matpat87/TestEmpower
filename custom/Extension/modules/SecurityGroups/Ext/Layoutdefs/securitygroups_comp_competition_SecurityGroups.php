<?php
 // created: 2018-07-04 17:18:26
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_comp_competition'] = array (
  'order' => 100,
  'module' => 'COMP_Competition',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_COMP_COMPETITION_FROM_COMP_COMPETITION_TITLE',
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
