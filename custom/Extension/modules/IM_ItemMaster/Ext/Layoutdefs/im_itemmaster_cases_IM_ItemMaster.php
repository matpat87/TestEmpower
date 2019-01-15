<?php
 // created: 2019-01-14 16:45:34
$layout_defs["IM_ItemMaster"]["subpanel_setup"]['im_itemmaster_cases'] = array (
  'order' => 100,
  'module' => 'Cases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_IM_ITEMMASTER_CASES_FROM_CASES_TITLE',
  'get_subpanel_data' => 'im_itemmaster_cases',
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
