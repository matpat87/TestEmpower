<?php
// created: 2021-04-08 09:34:48
$dictionary["PA_PreventiveActions"]["fields"]["cases_pa_preventiveactions_1"] = array (
  'name' => 'cases_pa_preventiveactions_1',
  'type' => 'link',
  'relationship' => 'cases_pa_preventiveactions_1',
  'source' => 'non-db',
  'module' => 'Cases',
  'bean_name' => 'Case',
  'vname' => 'LBL_CASES_PA_PREVENTIVEACTIONS_1_FROM_CASES_TITLE',
  'id_name' => 'cases_pa_preventiveactions_1cases_ida',
);
$dictionary["PA_PreventiveActions"]["fields"]["cases_pa_preventiveactions_1_name"] = array (
  'name' => 'cases_pa_preventiveactions_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CASES_PA_PREVENTIVEACTIONS_1_FROM_CASES_TITLE',
  'save' => true,
  'id_name' => 'cases_pa_preventiveactions_1cases_ida',
  'link' => 'cases_pa_preventiveactions_1',
  'table' => 'cases',
  'module' => 'Cases',
  'rname' => 'name',
);
$dictionary["PA_PreventiveActions"]["fields"]["cases_pa_preventiveactions_1cases_ida"] = array (
  'name' => 'cases_pa_preventiveactions_1cases_ida',
  'type' => 'link',
  'relationship' => 'cases_pa_preventiveactions_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CASES_PA_PREVENTIVEACTIONS_1_FROM_PA_PREVENTIVEACTIONS_TITLE',
);
