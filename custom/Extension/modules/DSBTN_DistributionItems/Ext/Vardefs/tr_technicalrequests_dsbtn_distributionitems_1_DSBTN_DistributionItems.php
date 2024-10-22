<?php
// created: 2019-11-01 11:28:22
$dictionary["DSBTN_DistributionItems"]["fields"]["tr_technicalrequests_dsbtn_distributionitems_1"] = array (
  'name' => 'tr_technicalrequests_dsbtn_distributionitems_1',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_dsbtn_distributionitems_1',
  'source' => 'non-db',
  'module' => 'TR_TechnicalRequests',
  'bean_name' => 'TR_TechnicalRequests',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_DSBTN_DISTRIBUTIONITEMS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'id_name' => 'tr_technic76a9equests_ida',
);
$dictionary["DSBTN_DistributionItems"]["fields"]["tr_technicalrequests_dsbtn_distributionitems_1_name"] = array (
  'name' => 'tr_technicalrequests_dsbtn_distributionitems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_DSBTN_DISTRIBUTIONITEMS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'tr_technic76a9equests_ida',
  'link' => 'tr_technicalrequests_dsbtn_distributionitems_1',
  'table' => 'tr_technicalrequests',
  'module' => 'TR_TechnicalRequests',
  'rname' => 'name',
);
$dictionary["DSBTN_DistributionItems"]["fields"]["tr_technic76a9equests_ida"] = array (
  'name' => 'tr_technic76a9equests_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_dsbtn_distributionitems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_DSBTN_DISTRIBUTIONITEMS_1_FROM_DSBTN_DISTRIBUTIONITEMS_TITLE',
);
