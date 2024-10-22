<?php
 // created: 2018-08-19 15:53:46
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_notes'] = array (
  'order' => 100,
  'module' => 'Notes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_NOTES_FROM_NOTES_TITLE',
  'get_subpanel_data' => 'securitygroups_notes',
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
