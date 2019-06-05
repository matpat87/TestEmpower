<?php
$module_name = 'CI_CustomerItems';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
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
        'LBL_EDITVIEW_PANEL2' => 
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
            'name' => 'part_number',
            'label' => 'LBL_PART_NUMBER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'ci_customeritems_ci_customeritems_name',
            'label' => 'LBL_CI_CUSTOMERITEMS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_L_TITLE',
          ),
        ),
        2 => 
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
        3 => 
        array (
          0 => 
          array (
            'name' => 'url',
            'label' => 'LBL_URL',
          ),
          1 => 
          array (
            'name' => 'ci_customeritems_project_name',
            'label' => 'LBL_CI_CUSTOMERITEMS_PROJECT_FROM_PROJECT_TITLE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => 
          array (
            'name' => 'product_image',
            'customCode' => '{$PRODUCT_IMAGE}',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'ci_customeritems_accounts_name',
            'label' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
          ),
          1 => 
          array (
            'name' => 'location',
            'label' => 'LBL_LOCATION',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'weight',
            'label' => 'LBL_WEIGHT',
          ),
          1 => 
          array (
            'name' => 'container',
            'studio' => 'visible',
            'label' => 'LBL_CONTAINER',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'ci_customeritems_opportunities_name',
            'label' => 'LBL_CI_CUSTOMERITEMS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
          ),
          1 => '',
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