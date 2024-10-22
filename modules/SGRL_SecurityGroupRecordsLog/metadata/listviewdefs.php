<?php
$module_name = 'SGRL_SecurityGroupRecordsLog';
$listViewDefs [$module_name] = 
array (
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
  'SECGROUP_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SECGROUP_NAME',
    'id' => 'SECGROUP_ID',
    'module' => 'SecurityGroups',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'SECGROUP_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SECGROUP_ID',
    'width' => '10%',
    'default' => true,
  ),
  'SECGROUP_TYPE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SECGROUP_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'ACTION' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ACTION',
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
