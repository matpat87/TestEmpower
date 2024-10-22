<?php
// created: 2019-12-11 08:52:34
$dictionary["CI_CustomerItems"]["fields"]["tr_technicalrequests_ci_customeritems_1"] = array (
  'name' => 'tr_technicalrequests_ci_customeritems_1',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_ci_customeritems_1',
  'source' => 'non-db',
  'module' => 'TR_TechnicalRequests',
  'bean_name' => 'TR_TechnicalRequests',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_CI_CUSTOMERITEMS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'id_name' => 'tr_technicalrequests_ci_customeritems_1tr_technicalrequests_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["tr_technicalrequests_ci_customeritems_1_name"] = array (
  'name' => 'tr_technicalrequests_ci_customeritems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_CI_CUSTOMERITEMS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'tr_technicalrequests_ci_customeritems_1tr_technicalrequests_ida',
  'link' => 'tr_technicalrequests_ci_customeritems_1',
  'table' => 'tr_technicalrequests',
  'module' => 'TR_TechnicalRequests',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["tr_technicalrequests_ci_customeritems_1tr_technicalrequests_ida"] = array (
  'name' => 'tr_technicalrequests_ci_customeritems_1tr_technicalrequests_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_ci_customeritems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
);
