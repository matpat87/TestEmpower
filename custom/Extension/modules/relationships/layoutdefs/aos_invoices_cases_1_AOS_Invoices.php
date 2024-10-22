<?php
 // created: 2021-04-28 06:57:32
$layout_defs["AOS_Invoices"]["subpanel_setup"]['aos_invoices_cases_1'] = array (
  'order' => 100,
  'module' => 'Cases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_AOS_INVOICES_CASES_1_FROM_CASES_TITLE',
  'get_subpanel_data' => 'aos_invoices_cases_1',
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
