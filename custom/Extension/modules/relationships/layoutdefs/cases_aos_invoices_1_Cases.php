<?php
 // created: 2021-07-29 10:17:51
$layout_defs["Cases"]["subpanel_setup"]['cases_aos_invoices_1'] = array (
  'order' => 100,
  'module' => 'AOS_Invoices',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CASES_AOS_INVOICES_1_FROM_AOS_INVOICES_TITLE',
  'get_subpanel_data' => 'cases_aos_invoices_1',
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
