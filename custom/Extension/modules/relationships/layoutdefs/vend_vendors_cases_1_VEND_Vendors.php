<?php
 // created: 2018-08-02 15:09:20
$layout_defs["VEND_Vendors"]["subpanel_setup"]['vend_vendors_cases_1'] = array (
  'order' => 100,
  'module' => 'Cases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VEND_VENDORS_CASES_1_FROM_CASES_TITLE',
  'get_subpanel_data' => 'vend_vendors_cases_1',
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
