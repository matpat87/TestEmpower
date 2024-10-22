<?php
// created: 2021-06-30 11:58:11
$dictionary["PA_EHSActionItems"]["fields"]["ehs_ehs_pa_ehsactionitems_1"] = array (
  'name' => 'ehs_ehs_pa_ehsactionitems_1',
  'type' => 'link',
  'relationship' => 'ehs_ehs_pa_ehsactionitems_1',
  'source' => 'non-db',
  'module' => 'EHS_EHS',
  'bean_name' => 'EHS_EHS',
  'vname' => 'LBL_EHS_EHS_PA_EHSACTIONITEMS_1_FROM_EHS_EHS_TITLE',
  'id_name' => 'ehs_ehs_pa_ehsactionitems_1ehs_ehs_ida',
);
$dictionary["PA_EHSActionItems"]["fields"]["ehs_ehs_pa_ehsactionitems_1_name"] = array (
  'name' => 'ehs_ehs_pa_ehsactionitems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_EHS_EHS_PA_EHSACTIONITEMS_1_FROM_EHS_EHS_TITLE',
  'save' => true,
  'id_name' => 'ehs_ehs_pa_ehsactionitems_1ehs_ehs_ida',
  'link' => 'ehs_ehs_pa_ehsactionitems_1',
  'table' => 'ehs_ehs',
  'module' => 'EHS_EHS',
  'rname' => 'name',
);
$dictionary["PA_EHSActionItems"]["fields"]["ehs_ehs_pa_ehsactionitems_1ehs_ehs_ida"] = array (
  'name' => 'ehs_ehs_pa_ehsactionitems_1ehs_ehs_ida',
  'type' => 'link',
  'relationship' => 'ehs_ehs_pa_ehsactionitems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_EHS_EHS_PA_EHSACTIONITEMS_1_FROM_PA_EHSACTIONITEMS_TITLE',
);
