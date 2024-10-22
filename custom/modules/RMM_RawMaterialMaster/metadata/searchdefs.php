<?php
$module_name = 'RMM_RawMaterialMaster';
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
      'product_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PRODUCT_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'product_number',
      ),
      'color_index_name' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_COLOR_INDEX_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'color_index_name',
      ),
      'chemical_name' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_CHEMICAL_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'chemical_name',
      ),
      'cas_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_CAS_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'cas_number',
      ),
      'grade_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_GRADE',
        'width' => '10%',
        'name' => 'grade_c',
      ),
      'color_family_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_COLOR_FAMILY',
        'width' => '10%',
        'name' => 'color_family_c',
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
