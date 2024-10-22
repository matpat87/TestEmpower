<?php
// created: 2021-03-19 14:40:23
$dictionary["AOS_Invoices"]["fields"]["users_aos_invoices_1"] = array (
  'name' => 'users_aos_invoices_1',
  'type' => 'link',
  'relationship' => 'users_aos_invoices_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_AOS_INVOICES_1_FROM_USERS_TITLE',
  'id_name' => 'users_aos_invoices_1users_ida',
);
$dictionary["AOS_Invoices"]["fields"]["users_aos_invoices_1_name"] = array (
  'name' => 'users_aos_invoices_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_AOS_INVOICES_1_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_aos_invoices_1users_ida',
  'link' => 'users_aos_invoices_1',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["AOS_Invoices"]["fields"]["users_aos_invoices_1users_ida"] = array (
  'name' => 'users_aos_invoices_1users_ida',
  'type' => 'link',
  'relationship' => 'users_aos_invoices_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_AOS_INVOICES_1_FROM_AOS_INVOICES_TITLE',
);
