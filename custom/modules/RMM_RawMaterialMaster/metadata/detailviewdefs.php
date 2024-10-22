<?php
$module_name = 'RMM_RawMaterialMaster';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'product_description',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT_DESCRIPTION',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'type_c',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'material_cost_type_c',
            'label' => 'LBL_MATERIAL_COST_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'grade_c',
            'label' => 'LBL_GRADE',
          ),
          1 => 
          array (
            'name' => 'color_family_c',
            'studio' => 'visible',
            'label' => 'LBL_COLOR_FAMILY',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'product_category_c',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT_CATEGORY',
            'customCode' => '<a href="index.php?module=AOS_Product_Categories&action=DetailView&record={$PRODUCT_CATEGORY_ID}">{$PRODUCT_CATEGORY_NAME}</a>',
          ),
          1 => '',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'cas_number',
            'label' => 'LBL_CAS_NUMBER',
          ),
          1 => 
          array (
            'name' => 'chemical_name',
            'label' => 'LBL_CHEMICAL_NAME',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'color_index_name',
            'label' => 'LBL_COLOR_INDEX_NAME',
          ),
          1 => 
          array (
            'name' => 'pricing_sheet',
            'label' => 'LBL_PRICING_SHEET',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'tds_c',
            'studio' => 'visible',
            'label' => 'LBL_TDS',
          ),
          1 => 
          array (
            'name' => 'sds_c',
            'studio' => 'visible',
            'label' => 'LBL_SDS',
          ),
        ),
      ),
    ),
  ),
);
;
?>
