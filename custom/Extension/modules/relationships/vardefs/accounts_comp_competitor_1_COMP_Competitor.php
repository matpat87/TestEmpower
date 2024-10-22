<?php
// created: 2021-11-23 02:08:21
$dictionary["COMP_Competitor"]["fields"]["accounts_comp_competitor_1"] = array (
  'name' => 'accounts_comp_competitor_1',
  'type' => 'link',
  'relationship' => 'accounts_comp_competitor_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_ACCOUNTS_COMP_COMPETITOR_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'accounts_comp_competitor_1accounts_ida',
);
$dictionary["COMP_Competitor"]["fields"]["accounts_comp_competitor_1_name"] = array (
  'name' => 'accounts_comp_competitor_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_COMP_COMPETITOR_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_comp_competitor_1accounts_ida',
  'link' => 'accounts_comp_competitor_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["COMP_Competitor"]["fields"]["accounts_comp_competitor_1accounts_ida"] = array (
  'name' => 'accounts_comp_competitor_1accounts_ida',
  'type' => 'link',
  'relationship' => 'accounts_comp_competitor_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_COMP_COMPETITOR_1_FROM_COMP_COMPETITOR_TITLE',
);
