<?php
// created: 2021-08-15 13:54:27
$dictionary["Call"]["fields"]["chl_challenges_calls_1"] = array (
  'name' => 'chl_challenges_calls_1',
  'type' => 'link',
  'relationship' => 'chl_challenges_calls_1',
  'source' => 'non-db',
  'module' => 'CHL_Challenges',
  'bean_name' => 'CHL_Challenges',
  'vname' => 'LBL_CHL_CHALLENGES_CALLS_1_FROM_CHL_CHALLENGES_TITLE',
  'id_name' => 'chl_challenges_calls_1chl_challenges_ida',
);
$dictionary["Call"]["fields"]["chl_challenges_calls_1_name"] = array (
  'name' => 'chl_challenges_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CHL_CHALLENGES_CALLS_1_FROM_CHL_CHALLENGES_TITLE',
  'save' => true,
  'id_name' => 'chl_challenges_calls_1chl_challenges_ida',
  'link' => 'chl_challenges_calls_1',
  'table' => 'chl_challenges',
  'module' => 'CHL_Challenges',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["chl_challenges_calls_1chl_challenges_ida"] = array (
  'name' => 'chl_challenges_calls_1chl_challenges_ida',
  'type' => 'link',
  'relationship' => 'chl_challenges_calls_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CHL_CHALLENGES_CALLS_1_FROM_CALLS_TITLE',
);
