<?php
 // created: 2022-05-03 06:20:49
$layout_defs["TR_TechnicalRequests"]["subpanel_setup"]['tr_technicalrequests_aos_products_2'] = array (
  'order' => 1,
  'module' => 'AOS_Products',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TR_TECHNICALREQUESTS_AOS_PRODUCTS_2_FROM_AOS_PRODUCTS_TITLE',
  'get_subpanel_data' => 'tr_technicalrequests_aos_products_2',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectProductMasterButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
