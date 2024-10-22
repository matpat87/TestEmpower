<?php
// created: 2021-01-24 06:40:16
$dictionary["ODR_SalesOrders"]["fields"]["calls_odr_salesorders_1"] = array (
  'name' => 'calls_odr_salesorders_1',
  'type' => 'link',
  'relationship' => 'calls_odr_salesorders_1',
  'source' => 'non-db',
  'module' => 'Calls',
  'bean_name' => 'Call',
  'vname' => 'LBL_CALLS_ODR_SALESORDERS_1_FROM_CALLS_TITLE',
  'id_name' => 'calls_odr_salesorders_1calls_ida',
);
$dictionary["ODR_SalesOrders"]["fields"]["calls_odr_salesorders_1_name"] = array (
  'name' => 'calls_odr_salesorders_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CALLS_ODR_SALESORDERS_1_FROM_CALLS_TITLE',
  'save' => true,
  'id_name' => 'calls_odr_salesorders_1calls_ida',
  'link' => 'calls_odr_salesorders_1',
  'table' => 'calls',
  'module' => 'Calls',
  'rname' => 'name',
);
$dictionary["ODR_SalesOrders"]["fields"]["calls_odr_salesorders_1calls_ida"] = array (
  'name' => 'calls_odr_salesorders_1calls_ida',
  'type' => 'link',
  'relationship' => 'calls_odr_salesorders_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CALLS_ODR_SALESORDERS_1_FROM_ODR_SALESORDERS_TITLE',
);
