<?php
$module_name = 'RMM_RawMaterialMaster';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/RMM_RawMaterialMaster/js/custom-edit.js',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'customCode' => '<input type="text" name="{$fields.name.name}" id="{$fields.name.name}" value="{$fields.name.value}" maxlength="{$fields.name.len}" class="custom-readonly" readonly="readonly" />',
          ),
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
