<?php
// created: 2019-11-28 06:55:56
$dictionary["Account"]["fields"]["users_accounts_2"] = array (
  'name' => 'users_accounts_2',
  'type' => 'link',
  'relationship' => 'users_accounts_2',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_ACCOUNTS_2_FROM_USERS_TITLE',
  'id_name' => 'users_accounts_2users_ida',
);
$dictionary["Account"]["fields"]["users_accounts_2_name"] = array (
  'name' => 'users_accounts_2_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_ACCOUNTS_2_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_accounts_2users_ida',
  'link' => 'users_accounts_2',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["users_accounts_2users_ida"] = array (
  'name' => 'users_accounts_2users_ida',
  'type' => 'link',
  'relationship' => 'users_accounts_2',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_ACCOUNTS_2_FROM_ACCOUNTS_TITLE',
);
