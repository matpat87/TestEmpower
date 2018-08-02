<?php
// created: 2018-08-02 15:09:20
$dictionary["Case"]["fields"]["vend_vendors_cases_1"] = array (
  'name' => 'vend_vendors_cases_1',
  'type' => 'link',
  'relationship' => 'vend_vendors_cases_1',
  'source' => 'non-db',
  'module' => 'VEND_Vendors',
  'bean_name' => 'VEND_Vendors',
  'vname' => 'LBL_VEND_VENDORS_CASES_1_FROM_VEND_VENDORS_TITLE',
  'id_name' => 'vend_vendors_cases_1vend_vendors_ida',
);
$dictionary["Case"]["fields"]["vend_vendors_cases_1_name"] = array (
  'name' => 'vend_vendors_cases_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VEND_VENDORS_CASES_1_FROM_VEND_VENDORS_TITLE',
  'save' => true,
  'id_name' => 'vend_vendors_cases_1vend_vendors_ida',
  'link' => 'vend_vendors_cases_1',
  'table' => 'vend_vendors',
  'module' => 'VEND_Vendors',
  'rname' => 'name',
);
$dictionary["Case"]["fields"]["vend_vendors_cases_1vend_vendors_ida"] = array (
  'name' => 'vend_vendors_cases_1vend_vendors_ida',
  'type' => 'link',
  'relationship' => 'vend_vendors_cases_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VEND_VENDORS_CASES_1_FROM_CASES_TITLE',
);
