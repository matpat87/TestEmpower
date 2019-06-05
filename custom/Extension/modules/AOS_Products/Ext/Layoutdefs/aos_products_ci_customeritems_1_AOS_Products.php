<?php
 // created: 2019-06-05 04:33:02
$layout_defs["AOS_Products"]["subpanel_setup"]['aos_products_ci_customeritems_1'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_AOS_PRODUCTS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'aos_products_ci_customeritems_1',
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
