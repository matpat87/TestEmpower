<?php
$module_name = 'AAR_AccountActivityReport';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'custom_account' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_CUSTOM_ACCOUNT',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_account',
      ),
      'custom_activity_type' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_CUSTOM_ACTIVITY_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_activity_type',
      ),
      'custom_related_to' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_CUSTOM_RELATED_TO',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_related_to',
      ),
      'custom_date_from' => 
      array (
        'type' => 'date',
        'label' => 'LBL_CUSTOM_DATE_FROM',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_date_from',
      ),
      'custom_date_to' => 
      array (
        'type' => 'date',
        'label' => 'LBL_CUSTOM_DATE_TO',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_date_to',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
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
