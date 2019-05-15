<?php
// created: 2019-02-04 16:24:24
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_accounts"] = array (
  'name' => 'ci_customeritems_accounts',
  'type' => 'link',
  'relationship' => 'ci_customeritems_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'id_name' => 'ci_customeritems_accountsaccounts_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_accounts_name"] = array (
  'name' => 'ci_customeritems_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'required' => true,
  'vname' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_accountsaccounts_ida',
  'link' => 'ci_customeritems_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_accountsaccounts_ida"] = array (
  'name' => 'ci_customeritems_accountsaccounts_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_accounts',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_CI_CUSTOMERITEMS_TITLE',
);
