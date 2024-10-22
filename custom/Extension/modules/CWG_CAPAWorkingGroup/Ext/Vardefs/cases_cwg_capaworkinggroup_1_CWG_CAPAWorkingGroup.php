<?php
// created: 2021-03-01 05:47:25
$dictionary["CWG_CAPAWorkingGroup"]["fields"]["cases_cwg_capaworkinggroup_1"] = array (
  'name' => 'cases_cwg_capaworkinggroup_1',
  'type' => 'link',
  'relationship' => 'cases_cwg_capaworkinggroup_1',
  'source' => 'non-db',
  'module' => 'Cases',
  'bean_name' => 'Case',
  'vname' => 'LBL_CASES_CWG_CAPAWORKINGGROUP_1_FROM_CASES_TITLE',
  'id_name' => 'cases_cwg_capaworkinggroup_1cases_ida',
);
$dictionary["CWG_CAPAWorkingGroup"]["fields"]["cases_cwg_capaworkinggroup_1_name"] = array (
  'name' => 'cases_cwg_capaworkinggroup_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CASES_CWG_CAPAWORKINGGROUP_1_FROM_CASES_TITLE',
  'save' => true,
  'id_name' => 'cases_cwg_capaworkinggroup_1cases_ida',
  'link' => 'cases_cwg_capaworkinggroup_1',
  'table' => 'cases',
  'module' => 'Cases',
  'rname' => 'name',
);
$dictionary["CWG_CAPAWorkingGroup"]["fields"]["cases_cwg_capaworkinggroup_1cases_ida"] = array (
  'name' => 'cases_cwg_capaworkinggroup_1cases_ida',
  'type' => 'link',
  'relationship' => 'cases_cwg_capaworkinggroup_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CASES_CWG_CAPAWORKINGGROUP_1_FROM_CWG_CAPAWORKINGGROUP_TITLE',
);
