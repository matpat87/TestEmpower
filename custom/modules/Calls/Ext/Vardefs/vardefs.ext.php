<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2018-07-03 16:48:14
$dictionary["Call"]["fields"]["ehs_ehs_calls_1"] = array (
  'name' => 'ehs_ehs_calls_1',
  'type' => 'link',
  'relationship' => 'ehs_ehs_calls_1',
  'source' => 'non-db',
  'module' => 'EHS_EHS',
  'bean_name' => 'EHS_EHS',
  'vname' => 'LBL_EHS_EHS_CALLS_1_FROM_EHS_EHS_TITLE',
);


// created: 2018-06-23 09:08:23
$dictionary["Call"]["fields"]["re_regulatory_calls_1"] = array (
  'name' => 're_regulatory_calls_1',
  'type' => 'link',
  'relationship' => 're_regulatory_calls_1',
  'source' => 'non-db',
  'module' => 'RE_Regulatory',
  'bean_name' => 'RE_Regulatory',
  'vname' => 'LBL_RE_REGULATORY_CALLS_1_FROM_RE_REGULATORY_TITLE',
  'id_name' => 're_regulatory_calls_1re_regulatory_ida',
);
$dictionary["Call"]["fields"]["re_regulatory_calls_1_name"] = array (
  'name' => 're_regulatory_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RE_REGULATORY_CALLS_1_FROM_RE_REGULATORY_TITLE',
  'save' => true,
  'id_name' => 're_regulatory_calls_1re_regulatory_ida',
  'link' => 're_regulatory_calls_1',
  'table' => 're_regulatory',
  'module' => 'RE_Regulatory',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["re_regulatory_calls_1re_regulatory_ida"] = array (
  'name' => 're_regulatory_calls_1re_regulatory_ida',
  'type' => 'link',
  'relationship' => 're_regulatory_calls_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_RE_REGULATORY_CALLS_1_FROM_CALLS_TITLE',
);

?>