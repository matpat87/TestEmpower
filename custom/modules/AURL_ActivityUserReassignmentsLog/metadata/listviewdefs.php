<?php
$module_name = 'AURL_ActivityUserReassignmentsLog';
$listViewDefs [$module_name] = 
array (
  'EVENT_LOG_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_EVENT_LOG_ID',
    'width' => '10%',
    'default' => true,
  ),
  'MODULE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MODULE',
    'width' => '10%',
    'default' => true,
  ),
  'RECORD_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_RECORD_NAME',
    'customCode' => '<a href="index.php?module={$MODULE}&amp;offset=4&amp;stamp=1594891939032078900&amp;return_module={$MODULE}&amp;action=DetailView&amp;record={$RECORD_ID}">
    {$RECORD_NAME}</a>',
    'width' => '10%',
    'default' => true,
  ),
  'RECORD_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_RECORD_ID',
    'width' => '10%',
    'default' => true,
  ),
  'OLD_ASSIGNED_USER_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_OLD_ASSIGNED_USER_NAME',
    'customCode' => '<a href="index.php?module=Users&amp;offset=4&amp;stamp=1594891939032078900&amp;return_module=Users&amp;action=DetailView&amp;record={$OLD_ASSIGNED_USER_ID}">
    {$OLD_ASSIGNED_USER_NAME}</a>',
    'width' => '10%',
    'default' => true,
  ),
  'OLD_ASSIGNED_USER_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_OLD_ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
  ),
  'NEW_ASSIGNED_USER_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NEW_ASSIGNED_USER_NAME',
    'customCode' => '<a href="index.php?module=Users&amp;offset=4&amp;stamp=1594891939032078900&amp;return_module=Users&amp;action=DetailView&amp;record={$NEW_ASSIGNED_USER_ID}">
    {$NEW_ASSIGNED_USER_NAME}</a>',
    'width' => '10%',
    'default' => true,
  ),
  'NEW_ASSIGNED_USER_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NEW_ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'module' => 'Employees',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
);
;
?>
