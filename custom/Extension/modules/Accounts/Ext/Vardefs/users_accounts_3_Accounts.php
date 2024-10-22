<?php
// created: 2023-08-04 16:25:01
$dictionary["Account"]["fields"]["users_accounts_3"] = array (
  'name' => 'users_accounts_3',
  'type' => 'link',
  'relationship' => 'users_accounts_3',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_ACCOUNTS_3_FROM_USERS_TITLE',
  'id_name' => 'users_accounts_3users_ida',
);
$dictionary["Account"]["fields"]["users_accounts_3_name"] = array (
  'name' => 'users_accounts_3_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_ACCOUNTS_3_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_accounts_3users_ida',
  'link' => 'users_accounts_3',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["users_accounts_3users_ida"] = array (
  'name' => 'users_accounts_3users_ida',
  'type' => 'link',
  'relationship' => 'users_accounts_3',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_ACCOUNTS_3_FROM_ACCOUNTS_TITLE',
);
