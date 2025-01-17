<?php
$module_name = 'CI_CustomerItems';
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
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL3' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL4' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL5' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL6' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
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
            'name' => 'ci_customeritems_aos_product_categories_name',
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
            'name' => 'ci_customeritems_ci_customeritems_name',
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
            'name' => 'price',
            'label' => 'LBL_PRICE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'ci_customeritems_contacts_name',
          ),
          1 => 
          array (
            'name' => 'url',
            'label' => 'LBL_URL',
          ),
        ),
        6 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'ci_customeritems_project_name',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'product_image',
            'label' => 'LBL_PRODUCT_IMAGE',
          ),
          1 => 
          array (
            'name' => 'ci_customeritems_accounts_name',
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
            'name' => 'unit_measure',
            'studio' => 'visible',
            'label' => 'LBL_UNIT_MEASURE',
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
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'ci_customeritems_opportunities_name',
          ),
          1 => 
          array (
            'name' => 'company_no',
            'studio' => 'visible',
            'label' => 'LBL_COMPANY_NO',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'location',
            'label' => 'LBL_LOCATION',
          ),
          1 => 
          array (
            'name' => 'material_cost_type',
            'label' => 'LBL_MATERIAL_COST_TYPE',
          ),
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
          0 => 'date_entered',
          1 => 'date_modified',
        ),
      ),
      'lbl_editview_panel2' => 
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
          0 => '',
          1 => '',
        ),
      ),
      'lbl_detailview_panel4' => 
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
      'lbl_detailview_panel5' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'volume_01_jan',
            'label' => 'LBL_VOLUME_01_JAN',
          ),
          1 => 
          array (
            'name' => 'volume_07_jul',
            'label' => 'LBL_VOLUME_07_JUL',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'volume_02_feb',
            'label' => 'LBL_VOLUME_02_FEB',
          ),
          1 => 
          array (
            'name' => 'volume_08_aug',
            'label' => 'LBL_VOLUME_08_AUG',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'volume_03_mar',
            'label' => 'LBL_VOLUME_03_MAR',
          ),
          1 => 
          array (
            'name' => 'volume_09_sep',
            'label' => 'LBL_VOLUME_09_SEP',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'volume_04_apr',
            'label' => 'LBL_VOLUME_04_APR',
          ),
          1 => 
          array (
            'name' => 'volume_10_oct',
            'label' => 'LBL_VOLUME_10_OCT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'volume_05_may',
            'label' => 'LBL_VOLUME_05_MAY',
          ),
          1 => 
          array (
            'name' => 'volume_11_nov',
            'label' => 'LBL_VOLUME_11_NOV',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'volume_06_jun',
            'label' => 'LBL_VOLUME_06_JUN',
          ),
          1 => 
          array (
            'name' => 'volume_12_dec',
            'label' => 'LBL_VOLUME_12_DEC',
          ),
        ),
      ),
      'lbl_detailview_panel6' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_01_jan',
            'label' => 'LBL_BUDGET_COST_01_JAN',
          ),
          1 => 
          array (
            'name' => 'budget_cost_07_jul',
            'label' => 'LBL_BUDGET_COST_07_JUL',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_02_feb',
            'label' => 'LBL_BUDGET_COST_02_FEB',
          ),
          1 => 
          array (
            'name' => 'budget_cost_08_aug',
            'label' => 'LBL_BUDGET_COST_08_AUG',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_03_mar',
            'label' => 'LBL_BUDGET_COST_03_MAR',
          ),
          1 => 
          array (
            'name' => 'budget_cost_09_sep',
            'label' => 'LBL_BUDGET_COST_09_SEP',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_04_apr',
            'label' => 'LBL_BUDGET_COST_04_APR',
          ),
          1 => 
          array (
            'name' => 'budget_cost_10_oct',
            'label' => 'LBL_BUDGET_COST_10_OCT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_05_may',
            'label' => 'LBL_BUDGET_COST_05_MAY',
          ),
          1 => 
          array (
            'name' => 'budget_cost_11_nov',
            'label' => 'LBL_BUDGET_COST_11_NOV',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_06_jun',
            'label' => 'LBL_BUDGET_COST_06_JUN',
          ),
          1 => 
          array (
            'name' => 'budget_cost_12_dec',
            'label' => 'LBL_BUDGET_COST_12_DEC',
          ),
        ),
      ),
    ),
  ),
);
;
?>
