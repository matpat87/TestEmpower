<?php
$module_name = 'CI_CustomerItems';
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
      'form' => 
      array (
        'enctype' => 'multipart/form-data',
        'headerTpl' => 'modules/CI_CustomerItems/tpls/EditViewHeader.tpl',
      ),
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/CI_CustomerItems/js/products.js',
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
      ),
      'syncDetailEditViews' => false,
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
            'customCode' => '{$PRODUCT_IMAGE}',
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
    ),
  ),
);
;
?>
