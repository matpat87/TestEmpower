<?php
$module_name = 'SO_SavingOpportunities';
$OBJECT_NAME = 'SO_SAVINGOPPORTUNITIES';
$listViewDefs [$module_name] = 
array (
  'SO_ID' => 
  array (
    'type' => 'int',
    'label' => 'LBL_SO_ID',
    'width' => '10%',
    'default' => true,
    'link' => true,
  ),
  'NAME' => 
  array (
    'width' => '30%',
    'label' => 'LBL_LIST_SALE_NAME',
    'link' => true,
    'default' => true,
  ),
  'SALES_STAGE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_SALE_STAGE',
    'default' => true,
  ),
  'AMOUNT_USDOLLAR' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_AMOUNT',
    'align' => 'right',
    'default' => true,
    'currency_format' => true,
  ),
  'DATE_CLOSED' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_DATE_CLOSED',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '5%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'SO_SAVINGOPPORTUNITIES_TYPE' => 
  array (
    'width' => '15%',
    'label' => 'LBL_TYPE',
    'default' => false,
  ),
  'LEAD_SOURCE' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LEAD_SOURCE',
    'default' => false,
  ),
  'NEXT_STEP' => 
  array (
    'width' => '10%',
    'label' => 'LBL_NEXT_STEP',
    'default' => false,
  ),
  'PROBABILITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PROBABILITY',
    'default' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'width' => '5%',
    'label' => 'LBL_MODIFIED',
    'default' => false,
  ),
);
;
?>
