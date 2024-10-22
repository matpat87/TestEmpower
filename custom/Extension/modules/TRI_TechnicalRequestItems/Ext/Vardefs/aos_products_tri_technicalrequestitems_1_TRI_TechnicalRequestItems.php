<?php
// created: 2021-03-11 05:19:44
$dictionary["TRI_TechnicalRequestItems"]["fields"]["aos_products_tri_technicalrequestitems_1"] = array (
  'name' => 'aos_products_tri_technicalrequestitems_1',
  'type' => 'link',
  'relationship' => 'aos_products_tri_technicalrequestitems_1',
  'source' => 'non-db',
  'module' => 'AOS_Products',
  'bean_name' => 'AOS_Products',
  'vname' => 'LBL_AOS_PRODUCTS_TRI_TECHNICALREQUESTITEMS_1_FROM_AOS_PRODUCTS_TITLE',
  'id_name' => 'aos_products_tri_technicalrequestitems_1aos_products_ida',
);
$dictionary["TRI_TechnicalRequestItems"]["fields"]["aos_products_tri_technicalrequestitems_1_name"] = array (
  'name' => 'aos_products_tri_technicalrequestitems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AOS_PRODUCTS_TRI_TECHNICALREQUESTITEMS_1_FROM_AOS_PRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'aos_products_tri_technicalrequestitems_1aos_products_ida',
  'link' => 'aos_products_tri_technicalrequestitems_1',
  'table' => 'aos_products',
  'module' => 'AOS_Products',
  'rname' => 'name',
);
$dictionary["TRI_TechnicalRequestItems"]["fields"]["aos_products_tri_technicalrequestitems_1aos_products_ida"] = array (
  'name' => 'aos_products_tri_technicalrequestitems_1aos_products_ida',
  'type' => 'link',
  'relationship' => 'aos_products_tri_technicalrequestitems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AOS_PRODUCTS_TRI_TECHNICALREQUESTITEMS_1_FROM_TRI_TECHNICALREQUESTITEMS_TITLE',
);
