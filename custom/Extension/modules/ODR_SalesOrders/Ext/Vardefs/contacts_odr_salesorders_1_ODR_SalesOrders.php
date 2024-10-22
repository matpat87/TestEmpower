<?php
// created: 2021-01-24 06:42:41
$dictionary["ODR_SalesOrders"]["fields"]["contacts_odr_salesorders_1"] = array (
  'name' => 'contacts_odr_salesorders_1',
  'type' => 'link',
  'relationship' => 'contacts_odr_salesorders_1',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'vname' => 'LBL_CONTACTS_ODR_SALESORDERS_1_FROM_CONTACTS_TITLE',
  'id_name' => 'contacts_odr_salesorders_1contacts_ida',
);
$dictionary["ODR_SalesOrders"]["fields"]["contacts_odr_salesorders_1_name"] = array (
  'name' => 'contacts_odr_salesorders_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTACTS_ODR_SALESORDERS_1_FROM_CONTACTS_TITLE',
  'save' => true,
  'id_name' => 'contacts_odr_salesorders_1contacts_ida',
  'link' => 'contacts_odr_salesorders_1',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["ODR_SalesOrders"]["fields"]["contacts_odr_salesorders_1contacts_ida"] = array (
  'name' => 'contacts_odr_salesorders_1contacts_ida',
  'type' => 'link',
  'relationship' => 'contacts_odr_salesorders_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CONTACTS_ODR_SALESORDERS_1_FROM_ODR_SALESORDERS_TITLE',
);
