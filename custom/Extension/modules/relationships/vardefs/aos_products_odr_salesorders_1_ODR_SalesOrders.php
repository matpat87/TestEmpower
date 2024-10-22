<?php
// created: 2021-03-17 12:52:08
$dictionary["ODR_SalesOrders"]["fields"]["aos_products_odr_salesorders_1"] = array (
  'name' => 'aos_products_odr_salesorders_1',
  'type' => 'link',
  'relationship' => 'aos_products_odr_salesorders_1',
  'source' => 'non-db',
  'module' => 'AOS_Products',
  'bean_name' => 'AOS_Products',
  'vname' => 'LBL_AOS_PRODUCTS_ODR_SALESORDERS_1_FROM_AOS_PRODUCTS_TITLE',
  'id_name' => 'aos_products_odr_salesorders_1aos_products_ida',
);
$dictionary["ODR_SalesOrders"]["fields"]["aos_products_odr_salesorders_1_name"] = array (
  'name' => 'aos_products_odr_salesorders_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AOS_PRODUCTS_ODR_SALESORDERS_1_FROM_AOS_PRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'aos_products_odr_salesorders_1aos_products_ida',
  'link' => 'aos_products_odr_salesorders_1',
  'table' => 'aos_products',
  'module' => 'AOS_Products',
  'rname' => 'name',
);
$dictionary["ODR_SalesOrders"]["fields"]["aos_products_odr_salesorders_1aos_products_ida"] = array (
  'name' => 'aos_products_odr_salesorders_1aos_products_ida',
  'type' => 'link',
  'relationship' => 'aos_products_odr_salesorders_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AOS_PRODUCTS_ODR_SALESORDERS_1_FROM_ODR_SALESORDERS_TITLE',
);
