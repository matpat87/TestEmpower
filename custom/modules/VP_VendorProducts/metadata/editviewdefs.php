<?php
$module_name = 'VP_VendorProducts';
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
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/VP_VendorProducts/js/custom-edit.js',
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
            'name' => 'vp_vendorproducts_rmm_rawmaterialmaster_name',
            'label' => 'LBL_VP_VENDORPRODUCTS_RMM_RAWMATERIALMASTER_FROM_RMM_RAWMATERIALMASTER_TITLE',
          ),
          1 => 
          array (
            'name' => 'vendor_product_status',
            'studio' => 'visible',
            'label' => 'LBL_VENDOR_PRODUCT_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'vend_vendors_vp_vendorproducts_1_name',
          ),
          1 => 
          array (
            'name' => 'contract_price',
            'studio' => 'visible',
            'label' => 'LBL_CONTRACT_PRICE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
            'customCode' => '<input type="text" name="{$fields.name.name}" id="{$fields.name.name}" value="{$fields.name.value}" maxlength="{$fields.name.len}" class="custom-readonly" readonly="readonly" /> ',
          ),
          1 => 
          array (
            'name' => 'vendor_description',
            'label' => 'LBL_VENDOR_DESCRIPTION',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'product_price_c',
            'label' => 'LBL_PRODUCT_PRICE',
            'customCode' => '<input type="text" name="{$fields.product_price_c.name}" id="{$fields.product_price_c.name}" value="{$fields.product_price_c.value}" maxlength="{$fields.product_price_c.len}" class="custom-currency" />',
          ),
          1 => 
          array (
            'name' => 'currency_id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'lead_time',
            'label' => 'LBL_LEAD_TIME',
          ),
          1 => 
          array (
            'name' => 'product_img_c',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT_IMG',
          ),
        ),
        5 => 
        array (
          0 => 'description',
        ),
        6 => 
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
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'payment_terms',
            'label' => 'LBL_PAYMENT_TERMS',
          ),
          1 => 
          array (
            'name' => 'freight_terms',
            'label' => 'LBL_FREIGHT_TERMS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'purchases_cytd',
            'label' => 'LBL_PURCHASES_CYTD',
          ),
          1 => 
          array (
            'name' => 'purchases_pytd',
            'label' => 'LBL_PURCHASES_PYTD',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'last_purchase_price',
            'label' => 'LBL_LAST_PURCHASE_PRICE',
            'customCode' => '<input type="text" name="{$fields.last_purchase_price.name}" id="{$fields.last_purchase_price.name}" value="{$fields.last_purchase_price.value}" maxlength="{$fields.last_purchase_price.len}" class="custom-currency" />',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
