<?php
$module_name = 'MKT_Markets';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'industry' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INDUSTRY',
        'width' => '10%',
        'default' => true,
        'name' => 'industry',
      ),
      'sub_industry_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_SUB_INDUSTRY',
        'width' => '10%',
        'name' => 'sub_industry_c',
      ),
    ),
    'advanced_search' => 
    array (
      'industry' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_INDUSTRY',
        'width' => '10%',
        'default' => true,
        'name' => 'industry',
      ),
      'sub_industry_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_SUB_INDUSTRY',
        'width' => '10%',
        'name' => 'sub_industry_c',
      ),
      'region' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_REGION',
        'width' => '10%',
        'default' => true,
        'name' => 'region',
      ),
      'macromarket' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_MACROMARKET',
        'width' => '10%',
        'default' => true,
        'name' => 'macromarket',
      ),
      'division' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DIVISION',
        'width' => '10%',
        'default' => true,
        'name' => 'division',
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
