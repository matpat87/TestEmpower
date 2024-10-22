<?php
$module_name = 'DSBTN_Distribution';
$listViewDefs [$module_name] = 
array (
  'CUSTOM_OPPORTUNITY_NUMBER_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_OPPORTUNITY_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_TECHNICAL_REQUEST_NUMBER_NON_DB' => 
  array (
    'type' => 'relate',
    'default' => true,
    'label' => 'LBL_TECHNICAL_REQUEST_NUMBER',
    'width' => '5%',
    'studio' => 'visible',
    'customCode' => '{$CUSTOM_TECHNICAL_REQUEST_NUMBER_NON_DB}',
  ),
  'DISTRIBUTION_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_DISTRIBUTION_NUMBER',
    'width' => '5%',
    'link' => true,
  ),
  'CONTACT_C' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_CONTACT',
    'id' => 'CONTACT_ID_C',
    'link' => false,
    'width' => '5%',
  ),
  'ACCOUNT_C' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => false,
    'width' => '5%',
  ),
  'CUSTOM_TECHNICAL_REQUEST_PRODUCT_NAME_NON_DB' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_TECHNICAL_REQUEST_PRODUCT_NAME',
    'width' => '5%',
  ),
  'DISTRO_ITEM_NON_DB' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_DISTRO_ITEM',
    'width' => '5%',
  ),
  'DISTRO_ITEM_QTY_NON_DB' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_DISTRO_ITEM_QTY',
    'width' => '5%',
  ),
  'DISTRO_ITEM_DELIVERY_METHOD_NON_DB' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_DISTRO_ITEM_DELIVERY_METHOD',
    'width' => '5%',
  ),
  'DISTRO_ITEM_STATUS_NON_DB' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_DISTRO_ITEM_STATUS',
    'width' => '5%',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '5%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
);
;
?>
