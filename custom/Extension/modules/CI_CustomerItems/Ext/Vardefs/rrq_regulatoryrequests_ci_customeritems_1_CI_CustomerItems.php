<?php
// created: 2022-10-09 06:12:57
$dictionary["CI_CustomerItems"]["fields"]["rrq_regulatoryrequests_ci_customeritems_1"] = array (
  'name' => 'rrq_regulatoryrequests_ci_customeritems_1',
  'type' => 'link',
  'relationship' => 'rrq_regulatoryrequests_ci_customeritems_1',
  'source' => 'non-db',
  'module' => 'RRQ_RegulatoryRequests',
  'bean_name' => 'RRQ_RegulatoryRequests',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_CI_CUSTOMERITEMS_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
  'id_name' => 'rrq_regula436cequests_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["rrq_regulatoryrequests_ci_customeritems_1_name"] = array (
  'name' => 'rrq_regulatoryrequests_ci_customeritems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_CI_CUSTOMERITEMS_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'rrq_regula436cequests_ida',
  'link' => 'rrq_regulatoryrequests_ci_customeritems_1',
  'table' => 'rrq_regulatoryrequests',
  'module' => 'RRQ_RegulatoryRequests',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["rrq_regula436cequests_ida"] = array (
  'name' => 'rrq_regula436cequests_ida',
  'type' => 'link',
  'relationship' => 'rrq_regulatoryrequests_ci_customeritems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
);
