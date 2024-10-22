<?php
 // created: 2018-08-19 15:53:46
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_aos_quotes'] = array (
  'order' => 100,
  'module' => 'AOS_Quotes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_AOS_QUOTES_FROM_AOS_QUOTES_TITLE',
  'get_subpanel_data' => 'securitygroups_aos_quotes',
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
