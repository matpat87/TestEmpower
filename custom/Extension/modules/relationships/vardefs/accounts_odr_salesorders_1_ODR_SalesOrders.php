<?php
// created: 2021-01-24 06:32:52
$dictionary["ODR_SalesOrders"]["fields"]["accounts_odr_salesorders_1"] = array (
  'name' => 'accounts_odr_salesorders_1',
  'type' => 'link',
  'relationship' => 'accounts_odr_salesorders_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'accounts_odr_salesorders_1accounts_ida',
);
$dictionary["ODR_SalesOrders"]["fields"]["accounts_odr_salesorders_1_name"] = array (
  'name' => 'accounts_odr_salesorders_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_odr_salesorders_1accounts_ida',
  'link' => 'accounts_odr_salesorders_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["ODR_SalesOrders"]["fields"]["accounts_odr_salesorders_1accounts_ida"] = array (
  'name' => 'accounts_odr_salesorders_1accounts_ida',
  'type' => 'link',
  'relationship' => 'accounts_odr_salesorders_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ODR_SALESORDERS_TITLE',
);
