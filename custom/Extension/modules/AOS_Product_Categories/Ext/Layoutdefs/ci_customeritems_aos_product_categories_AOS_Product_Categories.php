<?php
 // created: 2019-02-04 16:24:24
$layout_defs["AOS_Product_Categories"]["subpanel_setup"]['ci_customeritems_aos_product_categories'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCT_CATEGORIES_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'ci_customeritems_aos_product_categories',
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