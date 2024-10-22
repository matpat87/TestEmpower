<?php
// created: 2021-04-08 09:58:11
$dictionary["Call"]["fields"]["pa_preventiveactions_calls_1"] = array (
  'name' => 'pa_preventiveactions_calls_1',
  'type' => 'link',
  'relationship' => 'pa_preventiveactions_calls_1',
  'source' => 'non-db',
  'module' => 'PA_PreventiveActions',
  'bean_name' => 'PA_PreventiveActions',
  'vname' => 'LBL_PA_PREVENTIVEACTIONS_CALLS_1_FROM_PA_PREVENTIVEACTIONS_TITLE',
  'id_name' => 'pa_preventiveactions_calls_1pa_preventiveactions_ida',
);
$dictionary["Call"]["fields"]["pa_preventiveactions_calls_1_name"] = array (
  'name' => 'pa_preventiveactions_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PA_PREVENTIVEACTIONS_CALLS_1_FROM_PA_PREVENTIVEACTIONS_TITLE',
  'save' => true,
  'id_name' => 'pa_preventiveactions_calls_1pa_preventiveactions_ida',
  'link' => 'pa_preventiveactions_calls_1',
  'table' => 'pa_preventiveactions',
  'module' => 'PA_PreventiveActions',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["pa_preventiveactions_calls_1pa_preventiveactions_ida"] = array (
  'name' => 'pa_preventiveactions_calls_1pa_preventiveactions_ida',
  'type' => 'link',
  'relationship' => 'pa_preventiveactions_calls_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_PA_PREVENTIVEACTIONS_CALLS_1_FROM_CALLS_TITLE',
);
