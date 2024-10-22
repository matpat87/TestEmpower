<?php
// created: 2019-11-24 13:18:58
$dictionary["Account"]["fields"]["users_accounts_1"] = array (
  'name' => 'users_accounts_1',
  'type' => 'link',
  'relationship' => 'users_accounts_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_ACCOUNTS_1_FROM_USERS_TITLE',
  'id_name' => 'users_accounts_1users_ida',
);
$dictionary["Account"]["fields"]["users_accounts_1_name"] = array (
  'name' => 'users_accounts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_ACCOUNTS_1_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_accounts_1users_ida',
  'link' => 'users_accounts_1',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["users_accounts_1users_ida"] = array (
  'name' => 'users_accounts_1users_ida',
  'type' => 'link',
  'relationship' => 'users_accounts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
);
