<?php
 // created: 2020-11-11 12:34:39
$layout_defs["Cases"]["subpanel_setup"]['vi_vendorissues_cases_1'] = array (
  'order' => 100,
  'module' => 'VI_VendorIssues',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VI_VENDORISSUES_CASES_1_FROM_VI_VENDORISSUES_TITLE',
  'get_subpanel_data' => 'vi_vendorissues_cases_1',
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
