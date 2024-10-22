<?php
// created: 2021-04-28 06:57:32
$dictionary["Case"]["fields"]["aos_invoices_cases_1"] = array (
  'name' => 'aos_invoices_cases_1',
  'type' => 'link',
  'relationship' => 'aos_invoices_cases_1',
  'source' => 'non-db',
  'module' => 'AOS_Invoices',
  'bean_name' => 'AOS_Invoices',
  'vname' => 'LBL_AOS_INVOICES_CASES_1_FROM_AOS_INVOICES_TITLE',
  'id_name' => 'aos_invoices_cases_1aos_invoices_ida',
);
$dictionary["Case"]["fields"]["aos_invoices_cases_1_name"] = array (
  'name' => 'aos_invoices_cases_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AOS_INVOICES_CASES_1_FROM_AOS_INVOICES_TITLE',
  'save' => true,
  'id_name' => 'aos_invoices_cases_1aos_invoices_ida',
  'link' => 'aos_invoices_cases_1',
  'table' => 'aos_invoices',
  'module' => 'AOS_Invoices',
  'rname' => 'name',
);
$dictionary["Case"]["fields"]["aos_invoices_cases_1aos_invoices_ida"] = array (
  'name' => 'aos_invoices_cases_1aos_invoices_ida',
  'type' => 'link',
  'relationship' => 'aos_invoices_cases_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AOS_INVOICES_CASES_1_FROM_CASES_TITLE',
);
