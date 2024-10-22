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
            'name' => 'product_master_non_db',
            'customCode' => '<a href="index.php?module=AOS_Products&action=DetailView&record={$fields.aos_products_ci_customeritems_1aos_products_ida.value}"><span class="sugar_field" data-id-value="{$fields.aos_products_ci_customeritems_1aos_products_ida.value}">{$fields.product_master_non_db.value}</span>
            </a>',
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
            'label' => 'LBL_NAME',
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
          0 => 'date_entered',
          1 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'marketing_information_non_db',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'oem_account_c',
            'studio' => 'visible',
            'label' => 'LBL_OEM_ACCOUNT',
          ),
          1 => 
          array (
            'name' => 'new_market_c',
            'label' => 'LBL_MARKET',
          ),
        ),
        10 => 
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
            'customCode' => '{$SUB_INDUSTRY_NAME}',
          ),
        ),
        11 => 
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
            'customCode' => '{$INDUSTRY_NAME}',
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
