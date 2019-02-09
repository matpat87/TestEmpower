<?php
// created: 2019-02-09 10:43:31
$dictionary["AOS_Products_Quotes"]["fields"]["odr_salesorders_aos_products_quotes"] = array (
  'name' => 'odr_salesorders_aos_products_quotes',
  'type' => 'link',
  'relationship' => 'odr_salesorders_aos_products_quotes',
  'source' => 'non-db',
  'module' => 'ODR_SalesOrders',
  'bean_name' => false,
  'vname' => 'LBL_ODR_SALESORDERS_AOS_PRODUCTS_QUOTES_FROM_ODR_SALESORDERS_TITLE',
  'id_name' => 'odr_salesorders_aos_products_quotesodr_salesorders_ida',
);
$dictionary["AOS_Products_Quotes"]["fields"]["odr_salesorders_aos_products_quotes_name"] = array (
  'name' => 'odr_salesorders_aos_products_quotes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ODR_SALESORDERS_AOS_PRODUCTS_QUOTES_FROM_ODR_SALESORDERS_TITLE',
  'save' => true,
  'id_name' => 'odr_salesorders_aos_products_quotesodr_salesorders_ida',
  'link' => 'odr_salesorders_aos_products_quotes',
  'table' => 'odr_salesorders',
  'module' => 'ODR_SalesOrders',
  'rname' => 'name',
);
$dictionary["AOS_Products_Quotes"]["fields"]["odr_salesorders_aos_products_quotesodr_salesorders_ida"] = array (
  'name' => 'odr_salesorders_aos_products_quotesodr_salesorders_ida',
  'type' => 'link',
  'relationship' => 'odr_salesorders_aos_products_quotes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ODR_SALESORDERS_AOS_PRODUCTS_QUOTES_FROM_AOS_PRODUCTS_QUOTES_TITLE',
);
