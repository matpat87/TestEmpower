<?php
// created: 2023-08-31 16:58:52
$dictionary["APX_Lots"]["fields"]["apx_lots_aos_products"] = array (
  'name' => 'apx_lots_aos_products',
  'type' => 'link',
  'relationship' => 'apx_lots_aos_products',
  'source' => 'non-db',
  'module' => 'AOS_Products',
  'bean_name' => 'AOS_Products',
  'vname' => 'LBL_APX_LOTS_AOS_PRODUCTS_FROM_AOS_PRODUCTS_TITLE',
  'id_name' => 'apx_lots_aos_productsaos_products_ida',
);
$dictionary["APX_Lots"]["fields"]["apx_lots_aos_products_name"] = array (
  'name' => 'apx_lots_aos_products_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_APX_LOTS_AOS_PRODUCTS_FROM_AOS_PRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'apx_lots_aos_productsaos_products_ida',
  'link' => 'apx_lots_aos_products',
  'table' => 'aos_products',
  'module' => 'AOS_Products',
  'rname' => 'name',
);
$dictionary["APX_Lots"]["fields"]["apx_lots_aos_productsaos_products_ida"] = array (
  'name' => 'apx_lots_aos_productsaos_products_ida',
  'type' => 'link',
  'relationship' => 'apx_lots_aos_products',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_APX_LOTS_AOS_PRODUCTS_FROM_APX_LOTS_TITLE',
);
