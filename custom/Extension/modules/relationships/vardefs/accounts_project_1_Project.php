<?php
// created: 2019-02-14 16:41:05
$dictionary["Project"]["fields"]["accounts_project_1"] = array (
  'name' => 'accounts_project_1',
  'type' => 'link',
  'relationship' => 'accounts_project_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_PROJECT_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'accounts_project_1accounts_ida',
);
$dictionary["Project"]["fields"]["accounts_project_1_name"] = array (
  'name' => 'accounts_project_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_PROJECT_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_project_1accounts_ida',
  'link' => 'accounts_project_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["Project"]["fields"]["accounts_project_1accounts_ida"] = array (
  'name' => 'accounts_project_1accounts_ida',
  'type' => 'link',
  'relationship' => 'accounts_project_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_PROJECT_1_FROM_PROJECT_TITLE',
);
