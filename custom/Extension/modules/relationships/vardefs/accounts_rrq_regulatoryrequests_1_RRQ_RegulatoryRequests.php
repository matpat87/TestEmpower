<?php
// created: 2022-09-16 08:26:31
$dictionary["RRQ_RegulatoryRequests"]["fields"]["accounts_rrq_regulatoryrequests_1"] = array (
  'name' => 'accounts_rrq_regulatoryrequests_1',
  'type' => 'link',
  'relationship' => 'accounts_rrq_regulatoryrequests_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_RRQ_REGULATORYREQUESTS_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'accounts_rrq_regulatoryrequests_1accounts_ida',
);
$dictionary["RRQ_RegulatoryRequests"]["fields"]["accounts_rrq_regulatoryrequests_1_name"] = array (
  'name' => 'accounts_rrq_regulatoryrequests_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_RRQ_REGULATORYREQUESTS_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_rrq_regulatoryrequests_1accounts_ida',
  'link' => 'accounts_rrq_regulatoryrequests_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["RRQ_RegulatoryRequests"]["fields"]["accounts_rrq_regulatoryrequests_1accounts_ida"] = array (
  'name' => 'accounts_rrq_regulatoryrequests_1accounts_ida',
  'type' => 'link',
  'relationship' => 'accounts_rrq_regulatoryrequests_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_RRQ_REGULATORYREQUESTS_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
);
