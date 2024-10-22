<?php
// created: 2021-06-30 13:38:49
$dictionary["Call"]["fields"]["pa_ehsactionitems_calls_1"] = array (
  'name' => 'pa_ehsactionitems_calls_1',
  'type' => 'link',
  'relationship' => 'pa_ehsactionitems_calls_1',
  'source' => 'non-db',
  'module' => 'PA_EHSActionItems',
  'bean_name' => 'PA_EHSActionItems',
  'vname' => 'LBL_PA_EHSACTIONITEMS_CALLS_1_FROM_PA_EHSACTIONITEMS_TITLE',
  'id_name' => 'pa_ehsactionitems_calls_1pa_ehsactionitems_ida',
);
$dictionary["Call"]["fields"]["pa_ehsactionitems_calls_1_name"] = array (
  'name' => 'pa_ehsactionitems_calls_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PA_EHSACTIONITEMS_CALLS_1_FROM_PA_EHSACTIONITEMS_TITLE',
  'save' => true,
  'id_name' => 'pa_ehsactionitems_calls_1pa_ehsactionitems_ida',
  'link' => 'pa_ehsactionitems_calls_1',
  'table' => 'pa_ehsactionitems',
  'module' => 'PA_EHSActionItems',
  'rname' => 'name',
);
$dictionary["Call"]["fields"]["pa_ehsactionitems_calls_1pa_ehsactionitems_ida"] = array (
  'name' => 'pa_ehsactionitems_calls_1pa_ehsactionitems_ida',
  'type' => 'link',
  'relationship' => 'pa_ehsactionitems_calls_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_PA_EHSACTIONITEMS_CALLS_1_FROM_CALLS_TITLE',
);
