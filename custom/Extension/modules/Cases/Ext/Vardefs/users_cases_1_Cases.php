<?php
// created: 2018-12-09 15:56:54
$dictionary["Case"]["fields"]["users_cases_1"] = array (
  'name' => 'users_cases_1',
  'type' => 'link',
  'relationship' => 'users_cases_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_CASES_1_FROM_USERS_TITLE',
  'id_name' => 'users_cases_1users_ida',
);
$dictionary["Case"]["fields"]["users_cases_1_name"] = array (
  'name' => 'users_cases_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_CASES_1_FROM_USERS_TITLE',
  'required' => true,
  'save' => true,
  'id_name' => 'users_cases_1users_ida',
  'link' => 'users_cases_1',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["Case"]["fields"]["users_cases_1users_ida"] = array (
  'name' => 'users_cases_1users_ida',
  'type' => 'link',
  'relationship' => 'users_cases_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_CASES_1_FROM_CASES_TITLE',
);
