<?php
// created: 2023-08-31 16:58:52
$dictionary["Case"]["fields"]["apx_lots_cases"] = array (
  'name' => 'apx_lots_cases',
  'type' => 'link',
  'relationship' => 'apx_lots_cases',
  'source' => 'non-db',
  'module' => 'APX_Lots',
  'bean_name' => false,
  'vname' => 'LBL_APX_LOTS_CASES_FROM_APX_LOTS_TITLE',
  'id_name' => 'apx_lots_casesapx_lots_ida',
);
$dictionary["Case"]["fields"]["apx_lots_cases_name"] = array (
  'name' => 'apx_lots_cases_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_APX_LOTS_CASES_FROM_APX_LOTS_TITLE',
  'save' => true,
  'id_name' => 'apx_lots_casesapx_lots_ida',
  'link' => 'apx_lots_cases',
  'table' => 'apx_lots',
  'module' => 'APX_Lots',
  'rname' => 'name',
  'required' => true,
);
$dictionary["Case"]["fields"]["apx_lots_casesapx_lots_ida"] = array (
  'name' => 'apx_lots_casesapx_lots_ida',
  'type' => 'link',
  'relationship' => 'apx_lots_cases',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_APX_LOTS_CASES_FROM_CASES_TITLE',
);
