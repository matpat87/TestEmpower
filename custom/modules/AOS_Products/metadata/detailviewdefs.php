<?php
$module_name = 'AOS_Products';
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/AOS_Products/js/custom.js',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL4' => 
        array (
          'newTab' => true,
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
          0 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'division_c',
            'studio' => 'visible',
            'label' => 'LBL_DIVISION',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'part_number',
            'label' => 'LBL_PART_NUMBER',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'aos_product_category_name',
            'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
          ),
          1 => 
          array (
            'name' => 'type',
            'label' => 'LBL_TYPE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
          ),
          1 => 
          array (
            'name' => 'price',
            'label' => 'LBL_PRICE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
          1 => 
          array (
            'name' => 'url',
            'label' => 'LBL_URL',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'contact',
            'label' => 'LBL_CONTACT',
          ),
          1 => 
          array (
            'name' => 'project_c',
            'studio' => 'visible',
            'label' => 'LBL_PROJECT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => 
          array (
            'name' => 'unit_measure_c',
            'studio' => 'visible',
            'label' => 'LBL_UNIT_MEASURE',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'product_image',
            'label' => 'LBL_PRODUCT_IMAGE',
            'customCode' => '<img src="{$fields.product_image.value}"/>',
          ),
          1 => 
          array (
            'name' => 'company_no_c',
            'studio' => 'visible',
            'label' => 'LBL_COMPANY_NO',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'weight_c',
            'label' => 'LBL_WEIGHT',
          ),
          1 => 
          array (
            'name' => 'location_c',
            'label' => 'LBL_LOCATION',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'container_c',
            'studio' => 'visible',
            'label' => 'LBL_CONTAINER',
          ),
          1 => 
          array (
            'name' => 'material_cost_type_c',
            'label' => 'LBL_MATERIAL_COST_TYPE',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'opportunity_c',
            'studio' => 'visible',
            'label' => 'LBL_OPPORTUNITY',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
          1 => 
          array (
            'name' => 'modified_by_name',
            'label' => 'LBL_MODIFIED_NAME',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'comment' => 'Date record last modified',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
      ),
      'lbl_editview_panel3' => 
      array (
        0 => 
        array (
          0 => '',
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'cas_c',
            'label' => 'LBL_CAS',
          ),
          1 => 
          array (
            'name' => 'weight_per_gal_c',
            'label' => 'LBL_WEIGHT_PER_GAL',
          ),
        ),
      ),
      'lbl_detailview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'margin_c',
            'label' => 'LBL_MARGIN',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => '',
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'budget_jan_c',
            'label' => 'LBL_BUDGET_JAN',
          ),
          1 => 
          array (
            'name' => 'budget_jul_c',
            'label' => 'LBL_BUDGET_JUL',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'budget_feb_c',
            'label' => 'LBL_BUDGET_FEB',
          ),
          1 => 
          array (
            'name' => 'budget_aug_c',
            'label' => 'LBL_BUDGET_AUG',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'budget_mar_c',
            'label' => 'LBL_BUDGET_MAR',
          ),
          1 => 
          array (
            'name' => 'budget_sep_c',
            'label' => 'LBL_BUDGET_SEP',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'budget_apr_c',
            'label' => 'LBL_BUDGET_APR',
          ),
          1 => 
          array (
            'name' => 'budget_oct_c',
            'label' => 'LBL_BUDGET_OCT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'budget_may_c',
            'label' => 'LBL_BUDGET_MAY',
          ),
          1 => 
          array (
            'name' => 'budget_nov_c',
            'label' => 'LBL_BUDGET_NOV',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'budget_jun_c',
            'label' => 'LBL_BUDGET_JUN',
          ),
          1 => 
          array (
            'name' => 'budget_dec_c',
            'label' => 'LBL_BUDGET_DEC',
          ),
        ),
      ),
    ),
  ),
);
;
?>
