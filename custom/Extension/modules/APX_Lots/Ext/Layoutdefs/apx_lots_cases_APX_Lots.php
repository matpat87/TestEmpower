<?php
 // created: 2023-08-31 16:58:52
$layout_defs["APX_Lots"]["subpanel_setup"]['apx_lots_cases'] = array (
  'order' => 100,
  'module' => 'Cases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_APX_LOTS_CASES_FROM_CASES_TITLE',
  'get_subpanel_data' => 'apx_lots_cases',
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
