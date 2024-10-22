<?php
 // created: 2019-02-04 16:24:24
$layout_defs["CI_CustomerItems"]["subpanel_setup"]['ci_customeritems_aos_products_quotes'] = array (
  'order' => 100,
  'module' => 'AOS_Products_Quotes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCTS_QUOTES_FROM_AOS_PRODUCTS_QUOTES_TITLE',
  'get_subpanel_data' => 'ci_customeritems_aos_products_quotes',
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
