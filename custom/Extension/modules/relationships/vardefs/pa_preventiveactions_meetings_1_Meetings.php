<?php
// created: 2021-04-08 09:59:46
$dictionary["Meeting"]["fields"]["pa_preventiveactions_meetings_1"] = array (
  'name' => 'pa_preventiveactions_meetings_1',
  'type' => 'link',
  'relationship' => 'pa_preventiveactions_meetings_1',
  'source' => 'non-db',
  'module' => 'PA_PreventiveActions',
  'bean_name' => 'PA_PreventiveActions',
  'vname' => 'LBL_PA_PREVENTIVEACTIONS_MEETINGS_1_FROM_PA_PREVENTIVEACTIONS_TITLE',
  'id_name' => 'pa_preventiveactions_meetings_1pa_preventiveactions_ida',
);
$dictionary["Meeting"]["fields"]["pa_preventiveactions_meetings_1_name"] = array (
  'name' => 'pa_preventiveactions_meetings_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PA_PREVENTIVEACTIONS_MEETINGS_1_FROM_PA_PREVENTIVEACTIONS_TITLE',
  'save' => true,
  'id_name' => 'pa_preventiveactions_meetings_1pa_preventiveactions_ida',
  'link' => 'pa_preventiveactions_meetings_1',
  'table' => 'pa_preventiveactions',
  'module' => 'PA_PreventiveActions',
  'rname' => 'name',
);
$dictionary["Meeting"]["fields"]["pa_preventiveactions_meetings_1pa_preventiveactions_ida"] = array (
  'name' => 'pa_preventiveactions_meetings_1pa_preventiveactions_ida',
  'type' => 'link',
  'relationship' => 'pa_preventiveactions_meetings_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_PA_PREVENTIVEACTIONS_MEETINGS_1_FROM_MEETINGS_TITLE',
);
