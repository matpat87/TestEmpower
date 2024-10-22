<?php
// created: 2019-02-11 17:33:49
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_accounts"] = array (
  'name' => 'tr_technicalrequests_accounts',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'id_name' => 'tr_technicalrequests_accountsaccounts_ida',
);
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_accounts_name"] = array (
  'name' => 'tr_technicalrequests_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'tr_technicalrequests_accountsaccounts_ida',
  'link' => 'tr_technicalrequests_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
  'required' => true,
  'audited' => true,
);
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_accountsaccounts_ida"] = array (
  'name' => 'tr_technicalrequests_accountsaccounts_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_accounts',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_TR_TECHNICALREQUESTS_TITLE',
);
