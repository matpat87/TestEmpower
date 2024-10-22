<?php
$module_name = 'AURL_ActivityUserReassignmentsLog';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      'event_log_id' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_EVENT_LOG_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'event_log_id',
      ),
      'module' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_MODULE',
        'width' => '10%',
        'default' => true,
        'name' => 'module',
      ),
      'record_name' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_RECORD_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'record_name',
      ),
      'record_id' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_RECORD_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'record_id',
      ),
      'old_assigned_user_name' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_OLD_ASSIGNED_USER_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'old_assigned_user_name',
      ),
      'old_assigned_user_id' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_OLD_ASSIGNED_USER_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'old_assigned_user_id',
      ),
      'new_assigned_user_name' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_NEW_ASSIGNED_USER_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'new_assigned_user_name',
      ),
      'new_assigned_user_id' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_NEW_ASSIGNED_USER_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'new_assigned_user_id',
      ),
      'created_by' => 
      array (
        'type' => 'assigned_user_name',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => true,
        'name' => 'created_by',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
