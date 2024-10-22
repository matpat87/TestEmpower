<?php
// created: 2023-06-20 09:16:35
$dictionary["RRWG_RRWorkingGroup"]["fields"]["rrq_regulatoryrequests_rrwg_rrworkinggroup_1"] = array (
  'name' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
  'type' => 'link',
  'relationship' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
  'source' => 'non-db',
  'module' => 'RRQ_RegulatoryRequests',
  'bean_name' => 'RRQ_RegulatoryRequests',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_RRWG_RRWORKINGGROUP_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
  'id_name' => 'rrq_regula2443equests_ida',
);
$dictionary["RRWG_RRWorkingGroup"]["fields"]["rrq_regulatoryrequests_rrwg_rrworkinggroup_1_name"] = array (
  'name' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_RRWG_RRWORKINGGROUP_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'rrq_regula2443equests_ida',
  'link' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
  'table' => 'rrq_regulatoryrequests',
  'module' => 'RRQ_RegulatoryRequests',
  'rname' => 'name',
);
$dictionary["RRWG_RRWorkingGroup"]["fields"]["rrq_regula2443equests_ida"] = array (
  'name' => 'rrq_regula2443equests_ida',
  'type' => 'link',
  'relationship' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_RRWG_RRWORKINGGROUP_1_FROM_RRWG_RRWORKINGGROUP_TITLE',
);
