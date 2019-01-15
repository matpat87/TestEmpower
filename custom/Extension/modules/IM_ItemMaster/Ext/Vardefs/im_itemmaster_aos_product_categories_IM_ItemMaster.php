<?php
// created: 2019-01-14 16:45:34
$dictionary["IM_ItemMaster"]["fields"]["im_itemmaster_aos_product_categories"] = array (
  'name' => 'im_itemmaster_aos_product_categories',
  'type' => 'link',
  'relationship' => 'im_itemmaster_aos_product_categories',
  'source' => 'non-db',
  'module' => 'AOS_Product_Categories',
  'bean_name' => 'AOS_Product_Categories',
  'vname' => 'LBL_IM_ITEMMASTER_AOS_PRODUCT_CATEGORIES_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
  'id_name' => 'im_itemmaster_aos_product_categoriesaos_product_categories_ida',
);
$dictionary["IM_ItemMaster"]["fields"]["im_itemmaster_aos_product_categories_name"] = array (
  'name' => 'im_itemmaster_aos_product_categories_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_IM_ITEMMASTER_AOS_PRODUCT_CATEGORIES_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
  'save' => true,
  'id_name' => 'im_itemmaster_aos_product_categoriesaos_product_categories_ida',
  'link' => 'im_itemmaster_aos_product_categories',
  'table' => 'aos_product_categories',
  'module' => 'AOS_Product_Categories',
  'rname' => 'name',
);
$dictionary["IM_ItemMaster"]["fields"]["im_itemmaster_aos_product_categoriesaos_product_categories_ida"] = array (
  'name' => 'im_itemmaster_aos_product_categoriesaos_product_categories_ida',
  'type' => 'link',
  'relationship' => 'im_itemmaster_aos_product_categories',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_IM_ITEMMASTER_AOS_PRODUCT_CATEGORIES_FROM_IM_ITEMMASTER_TITLE',
);
