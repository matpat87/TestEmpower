<?php
$module_name = 'VP_VendorProducts';
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
            'label' => 'LBL_VEND_VENDORS_VP_VENDORPRODUCTS_1_FROM_VEND_VENDORS_TITLE',
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
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'studio' => 'visible',
            'label' => 'LBL_DESCRIPTION',
          ),
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
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
