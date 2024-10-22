<?php
// created: 2022-04-06 07:02:54
$dictionary["TR_TechnicalRequests"]["fields"]["ci_customeritems_tr_technicalrequests_1"] = array (
  'name' => 'ci_customeritems_tr_technicalrequests_1',
  'type' => 'link',
  'relationship' => 'ci_customeritems_tr_technicalrequests_1',
  'source' => 'non-db',
  'module' => 'CI_CustomerItems',
  'bean_name' => 'CI_CustomerItems',
  'vname' => 'LBL_CI_CUSTOMERITEMS_TR_TECHNICALREQUESTS_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'id_name' => 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida',
);
$dictionary["TR_TechnicalRequests"]["fields"]["ci_customeritems_tr_technicalrequests_1_name"] = array (
  'name' => 'ci_customeritems_tr_technicalrequests_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_TR_TECHNICALREQUESTS_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida',
  'link' => 'ci_customeritems_tr_technicalrequests_1',
  'table' => 'ci_customeritems',
  'module' => 'CI_CustomerItems',
  'rname' => 'name',
);
$dictionary["TR_TechnicalRequests"]["fields"]["ci_customeritems_tr_technicalrequests_1ci_customeritems_ida"] = array (
  'name' => 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_tr_technicalrequests_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_TR_TECHNICALREQUESTS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
);
