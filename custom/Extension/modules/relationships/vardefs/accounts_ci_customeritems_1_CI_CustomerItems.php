<?php
// created: 2019-05-08 15:27:33
$dictionary["CI_CustomerItems"]["fields"]["accounts_ci_customeritems_1"] = array (
  'name' => 'accounts_ci_customeritems_1',
  'type' => 'link',
  'relationship' => 'accounts_ci_customeritems_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_CI_CUSTOMERITEMS_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'accounts_ci_customeritems_1accounts_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["accounts_ci_customeritems_1_name"] = array (
  'name' => 'accounts_ci_customeritems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_CI_CUSTOMERITEMS_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_ci_customeritems_1accounts_ida',
  'link' => 'accounts_ci_customeritems_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["accounts_ci_customeritems_1accounts_ida"] = array (
  'name' => 'accounts_ci_customeritems_1accounts_ida',
  'type' => 'link',
  'relationship' => 'accounts_ci_customeritems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
);
