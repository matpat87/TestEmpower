<?php
// created: 2021-05-27 05:56:40
$dictionary["TRWG_TRWorkingGroup"]["fields"]["tr_technicalrequests_trwg_trworkinggroup_1"] = array (
  'name' => 'tr_technicalrequests_trwg_trworkinggroup_1',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_trwg_trworkinggroup_1',
  'source' => 'non-db',
  'module' => 'TR_TechnicalRequests',
  'bean_name' => 'TR_TechnicalRequests',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_TRWG_TRWORKINGGROUP_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'id_name' => 'tr_technic9742equests_ida',
);
$dictionary["TRWG_TRWorkingGroup"]["fields"]["tr_technicalrequests_trwg_trworkinggroup_1_name"] = array (
  'name' => 'tr_technicalrequests_trwg_trworkinggroup_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_TRWG_TRWORKINGGROUP_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'tr_technic9742equests_ida',
  'link' => 'tr_technicalrequests_trwg_trworkinggroup_1',
  'table' => 'tr_technicalrequests',
  'module' => 'TR_TechnicalRequests',
  'rname' => 'name',
);
$dictionary["TRWG_TRWorkingGroup"]["fields"]["tr_technic9742equests_ida"] = array (
  'name' => 'tr_technic9742equests_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_trwg_trworkinggroup_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_TRWG_TRWORKINGGROUP_1_FROM_TRWG_TRWORKINGGROUP_TITLE',
);
