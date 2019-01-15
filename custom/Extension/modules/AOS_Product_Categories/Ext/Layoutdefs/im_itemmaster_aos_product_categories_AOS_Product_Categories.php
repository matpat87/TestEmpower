<?php
 // created: 2019-01-14 16:45:34
$layout_defs["AOS_Product_Categories"]["subpanel_setup"]['im_itemmaster_aos_product_categories'] = array (
  'order' => 100,
  'module' => 'IM_ItemMaster',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_IM_ITEMMASTER_AOS_PRODUCT_CATEGORIES_FROM_IM_ITEMMASTER_TITLE',
  'get_subpanel_data' => 'im_itemmaster_aos_product_categories',
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
