<?php
// created: 2021-01-27 08:04:16
$dictionary["Case"]["fields"]["ci_customeritems_cases_1"] = array (
  'name' => 'ci_customeritems_cases_1',
  'type' => 'link',
  'relationship' => 'ci_customeritems_cases_1',
  'source' => 'non-db',
  'module' => 'CI_CustomerItems',
  'bean_name' => 'CI_CustomerItems',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CASES_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'id_name' => 'ci_customeritems_cases_1ci_customeritems_ida',
);
$dictionary["Case"]["fields"]["ci_customeritems_cases_1_name"] = array (
  'name' => 'ci_customeritems_cases_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CASES_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_cases_1ci_customeritems_ida',
  'link' => 'ci_customeritems_cases_1',
  'table' => 'ci_customeritems',
  'module' => 'CI_CustomerItems',
  'rname' => 'name',
);
$dictionary["Case"]["fields"]["ci_customeritems_cases_1ci_customeritems_ida"] = array (
  'name' => 'ci_customeritems_cases_1ci_customeritems_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_cases_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CASES_1_FROM_CASES_TITLE',
);
