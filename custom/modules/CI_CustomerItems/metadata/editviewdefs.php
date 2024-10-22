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
            'name' => 'product_master_non_db',
          ),
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'product_number_c',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT_NUMBER',
          ),
          1 => 
          array (
            'name' => 'ci_customeritems_accounts_name',
            'label' => 'LBL_ACCOUNT',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'version_c',
            'label' => 'LBL_VERSION',
          ),
          1 => 
          array (
            'name' => 'let_down_ratio_c',
            'studio' => 'visible',
            'label' => 'LBL_LET_DOWN_RATIO',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'customCode' => '
              <input type="text" name="name" id="name" size="30" maxlength="255" value="{$fields.name.value}" title="">
              <input type="hidden" name="aos_products_ci_customeritems_1_name" value="{$fields.aos_products_ci_customeritems_1_name.value}">
              <input type="hidden" name="aos_products_ci_customeritems_1aos_products_ida" value="{$fields.aos_products_ci_customeritems_1aos_products_ida.value}">
            ',
          ),
          1 => '',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'related_product_c',
            'studio' => 'visible',
            'label' => 'LBL_RELATED_PRODUCT',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'price',
            'label' => 'LBL_PRICE',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 'description',
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
            'type' => 'readonly',
          ),
        ),
        8 => 
        array (
          0 => '',
          1 => '',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'marketing_information_non_db',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'oem_account_c',
            'studio' => 'visible',
            'label' => 'LBL_OEM_ACCOUNT',
            'displayParams' => 
            array (
              'initial_filter' => '&oem_c_advanced=Yes&disable_security_groups_filter=true',
            ),
          ),
          1 => 
          array (
            'name' => 'new_market_c',
            'studio' => 'visible',
            'label' => 'LBL_MARKET',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'application_c',
            'label' => 'LBL_APPLICATION',
          ),
          1 => 
          array (
            'name' => 'sub_industry_c',
            'studio' => 'visible',
            'label' => 'LBL_SUB_INDUSTRY',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'product_image_pic_c',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT_IMAGE_PIC',
          ),
          1 => 
          array (
            'name' => 'industry_c',
            'studio' => 'visible',
            'label' => 'LBL_INDUSTRY',
          ),
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'customer_product_id_number_c',
            'label' => 'LBL_CUSTOMER_PRODUCT_ID_NUMBER',
          ),
          1 => 
          array (
            'name' => 'customer_description_c',
            'studio' => 'visible',
            'label' => 'LBL_CUSTOMER_DESCRIPTION',
          ),
        ),
      ),
    ),
  ),
);
;
?>
