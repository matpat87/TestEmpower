<?php
// created: 2021-08-15 13:36:42
$dictionary["CHL_Challenges"]["fields"]["accounts_chl_challenges_1"] = array (
  'name' => 'accounts_chl_challenges_1',
  'type' => 'link',
  'relationship' => 'accounts_chl_challenges_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_CHL_CHALLENGES_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'accounts_chl_challenges_1accounts_ida',
);
$dictionary["CHL_Challenges"]["fields"]["accounts_chl_challenges_1_name"] = array (
  'name' => 'accounts_chl_challenges_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_CHL_CHALLENGES_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_chl_challenges_1accounts_ida',
  'link' => 'accounts_chl_challenges_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["CHL_Challenges"]["fields"]["accounts_chl_challenges_1accounts_ida"] = array (
  'name' => 'accounts_chl_challenges_1accounts_ida',
  'type' => 'link',
  'relationship' => 'accounts_chl_challenges_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_CHL_CHALLENGES_1_FROM_CHL_CHALLENGES_TITLE',
);
