<?php
$module_name = 'SVR_SalesViewReport';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'assigned_to_c' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_USER',
        'width' => '10%',
        'default' => true,
        'name' => 'assigned_to_c',
        'displayParams' => 
        array (
          'size' => 1,
        ),
      ),
    ),
    'advanced_search' => 
    array (
      'assigned_to_c' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_USER',
        'width' => '10%',
        'default' => true,
        'name' => 'assigned_to_c',
        'displayParams' => 
        array (
          'size' => 1,
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
