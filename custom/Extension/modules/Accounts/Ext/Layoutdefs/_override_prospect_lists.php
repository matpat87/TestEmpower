<?php
 // created: 2024-03-06 15:05
$layout_defs["Accounts"]["subpanel_setup"]['prospect_lists'] = array (
  'order' => 100,
  'module' => 'ProspectLists',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROSPECT_LISTS_TITLE',
  'get_subpanel_data' => 'prospect_lists',
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
