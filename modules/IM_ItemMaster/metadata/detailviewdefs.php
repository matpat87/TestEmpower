<?php
$module_name = 'IM_ItemMaster';
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
        'LBL_DETAILVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL3' => 
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
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'division',
            'studio' => 'visible',
            'label' => 'LBL_DIVISION',
          ),
        ),
        1 => 
        array (
          0 => 'name',
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
            'name' => 'im_itemmaster_aos_product_categories_name',
          ),
          1 => 
          array (
            'name' => 'type',
            'studio' => 'visible',
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
            'studio' => 'visible',
            'label' => 'LBL_CONTACT',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'unit_measure',
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
            'name' => 'company_no',
            'studio' => 'visible',
            'label' => 'LBL_COMPANY_NO',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'weight',
            'label' => 'LBL_WEIGHT',
          ),
          1 => 
          array (
            'name' => 'location',
            'label' => 'LBL_LOCATION',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'container',
            'studio' => 'visible',
            'label' => 'LBL_CONTAINER',
          ),
          1 => 
          array (
            'name' => 'material_cost_type',
            'label' => 'LBL_MATERIAL_COST_TYPE',
          ),
        ),
        10 => 
        array (
          0 => '',
          1 => '',
        ),
      ),
      'lbl_detailview_panel1' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
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
          0 => 'date_entered',
          1 => 'date_modified',
        ),
      ),
      'lbl_detailview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'cas',
            'label' => 'LBL_CAS',
          ),
          1 => 
          array (
            'name' => 'weight_per_gal',
            'label' => 'LBL_WEIGHT_PER_GAL',
          ),
        ),
      ),
      'lbl_detailview_panel3' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'margin',
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
            'name' => 'budget_jan',
            'label' => 'LBL_BUDGET_JAN',
          ),
          1 => 
          array (
            'name' => 'budget_jul',
            'label' => 'LBL_BUDGET_JUL',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'budget_feb',
            'label' => 'LBL_BUDGET_FEB',
          ),
          1 => 
          array (
            'name' => 'budget_aug',
            'label' => 'LBL_BUDGET_AUG',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'budget_mar',
            'label' => 'LBL_BUDGET_MAR',
          ),
          1 => 
          array (
            'name' => 'budget_sep',
            'label' => 'LBL_BUDGET_SEP',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'budget_apr',
            'label' => 'LBL_BUDGET_APR',
          ),
          1 => 
          array (
            'name' => 'budget_oct',
            'label' => 'LBL_BUDGET_OCT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'budget_may',
            'label' => 'LBL_BUDGET_MAY',
          ),
          1 => 
          array (
            'name' => 'budget_nov',
            'label' => 'LBL_BUDGET_NOV',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'budget_jun',
            'label' => 'LBL_BUDGET_JUN',
          ),
          1 => 
          array (
            'name' => 'budget_dec',
            'label' => 'LBL_BUDGET_DEC',
          ),
        ),
      ),
    ),
  ),
);
;
?>
