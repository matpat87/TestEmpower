<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2011-03-22 13:25:17
$dictionary["asol_Events"]["fields"]["asol_events_asol_activity"] = array (
  'name' => 'asol_events_asol_activity',
  'type' => 'link',
  'relationship' => 'asol_events_asol_activity',
  'source' => 'non-db',
  'side' => 'right',
  'vname' => 'LBL_ASOL_EVENTS_ASOL_ACTIVITY_FROM_ASOL_ACTIVITY_TITLE',
);


// created: 2014-08-18 12:21:23
$dictionary["asol_Events"]["fields"]["asol_process_asol_events_1"] = array (
  'name' => 'asol_process_asol_events_1',
  'type' => 'link',
  'relationship' => 'asol_process_asol_events_1',
  'source' => 'non-db',
  'module' => 'asol_Process',
  'bean_name' => 'asol_Process',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_1_FROM_ASOL_PROCESS_TITLE',
  'id_name' => 'asol_process_asol_events_1asol_process_ida',
);
$dictionary["asol_Events"]["fields"]["asol_process_asol_events_1_name"] = array (
  'name' => 'asol_process_asol_events_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_1_FROM_ASOL_PROCESS_TITLE',
  'save' => true,
  'id_name' => 'asol_process_asol_events_1asol_process_ida',
  'link' => 'asol_process_asol_events_1',
  'table' => 'asol_process',
  'module' => 'asol_Process',
  'rname' => 'name',
);
$dictionary["asol_Events"]["fields"]["asol_process_asol_events_1asol_process_ida"] = array (
  'name' => 'asol_process_asol_events_1asol_process_ida',
  'type' => 'link',
  'relationship' => 'asol_process_asol_events_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_1_FROM_ASOL_EVENTS_TITLE',
);


// created: 2011-03-22 13:25:17
$dictionary["asol_Events"]["fields"]["asol_process_asol_events"] = array (
  'name' => 'asol_process_asol_events',
  'type' => 'link',
  'relationship' => 'asol_process_asol_events',
  'source' => 'non-db',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_FROM_ASOL_PROCESS_TITLE',
);
$dictionary["asol_Events"]["fields"]["asol_process_asol_events_name"] = array (
  'name' => 'asol_process_asol_events_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_FROM_ASOL_PROCESS_TITLE',
  'save' => true,
  'id_name' => 'asol_proce6f14process_ida',
  'link' => 'asol_process_asol_events',
  'table' => 'asol_process',
  'module' => 'asol_Process',
  'rname' => 'name',
);
$dictionary["asol_Events"]["fields"]["asol_proce6f14process_ida"] = array (
  'name' => 'asol_proce6f14process_ida',
  'type' => 'link',
  'relationship' => 'asol_process_asol_events',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_FROM_ASOL_EVENTS_TITLE',
);

?>