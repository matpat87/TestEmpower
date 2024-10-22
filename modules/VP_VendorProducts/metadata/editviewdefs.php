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
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'vendor_product_status',
            'studio' => 'visible',
            'label' => 'LBL_VENDOR_PRODUCT_STATUS',
          ),
        ),
        1 => 
        array (
          0 => '',
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
            'name' => 'vendor_product_number',
            'label' => 'LBL_VENDOR_PRODUCT_NUMBER',
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
            'name' => 'lead_time',
            'label' => 'LBL_LEAD_TIME',
          ),
          1 => '',
        ),
        4 => 
        array (
          0 => 'description',
          1 => '',
        ),
        5 => 
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
