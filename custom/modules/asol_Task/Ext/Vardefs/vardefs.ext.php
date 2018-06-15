<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2011-04-05 11:16:12
$dictionary["asol_Task"]["fields"]["asol_activity_asol_task"] = array (
  'name' => 'asol_activity_asol_task',
  'type' => 'link',
  'relationship' => 'asol_activity_asol_task',
  'source' => 'non-db',
  'vname' => 'LBL_ASOL_ACTIVITY_ASOL_TASK_FROM_ASOL_ACTIVITY_TITLE',
);
$dictionary["asol_Task"]["fields"]["asol_activity_asol_task_name"] = array (
  'name' => 'asol_activity_asol_task_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ASOL_ACTIVITY_ASOL_TASK_FROM_ASOL_ACTIVITY_TITLE',
  'save' => true,
  'id_name' => 'asol_activ5b86ctivity_ida',
  'link' => 'asol_activity_asol_task',
  'table' => 'asol_activity',
  'module' => 'asol_Activity',
  'rname' => 'name',
);
$dictionary["asol_Task"]["fields"]["asol_activ5b86ctivity_ida"] = array (
  'name' => 'asol_activ5b86ctivity_ida',
  'type' => 'link',
  'relationship' => 'asol_activity_asol_task',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ASOL_ACTIVITY_ASOL_TASK_FROM_ASOL_TASK_TITLE',
);


// created: 2014-08-18 12:21:23
$dictionary["asol_Task"]["fields"]["asol_process_asol_task"] = array (
  'name' => 'asol_process_asol_task',
  'type' => 'link',
  'relationship' => 'asol_process_asol_task',
  'source' => 'non-db',
  'module' => 'asol_Process',
  'bean_name' => 'asol_Process',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_TASK_FROM_ASOL_PROCESS_TITLE',
  'id_name' => 'asol_process_asol_taskasol_process_ida',
);
$dictionary["asol_Task"]["fields"]["asol_process_asol_task_name"] = array (
  'name' => 'asol_process_asol_task_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_TASK_FROM_ASOL_PROCESS_TITLE',
  'save' => true,
  'id_name' => 'asol_process_asol_taskasol_process_ida',
  'link' => 'asol_process_asol_task',
  'table' => 'asol_process',
  'module' => 'asol_Process',
  'rname' => 'name',
);
$dictionary["asol_Task"]["fields"]["asol_process_asol_taskasol_process_ida"] = array (
  'name' => 'asol_process_asol_taskasol_process_ida',
  'type' => 'link',
  'relationship' => 'asol_process_asol_task',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ASOL_PROCESS_ASOL_TASK_FROM_ASOL_TASK_TITLE',
);

?>