<?php
$module_name = 'SGRL_SecurityGroupRecordsLog';
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
      'module' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_MODULE',
        'width' => '10%',
        'default' => true,
        'name' => 'module',
      ),
      'secgroup_id' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_SECGROUP_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'secgroup_id',
      ),
      'record_id' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_RECORD_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'record_id',
      ),
      'action' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_ACTION',
        'width' => '10%',
        'default' => true,
        'name' => 'action',
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
