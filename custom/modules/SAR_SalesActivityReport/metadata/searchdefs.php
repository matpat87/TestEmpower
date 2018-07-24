<?php
$module_name = 'SAR_SalesActivityReport';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'assigned_to_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ASSIGNED_TO',
        'id' => 'USER_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'assigned_to_c',
      ),
      'assigned_account_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ASSIGNED_ACCOUNT',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'assigned_account_c',
      ),
      'activity_type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACTIVITY_TYPE',
        'width' => '10%',
        'name' => 'activity_type_c',
      ),
    ),
    'advanced_search' => 
    array (
      'related_to_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_RELATED_TO',
        'width' => '10%',
        'name' => 'related_to_c',
      ),
      'date_from_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_FROM',
        'width' => '10%',
        'name' => 'date_from_c',
      ),
      'date_to_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_TO',
        'width' => '10%',
        'name' => 'date_to_c',
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
