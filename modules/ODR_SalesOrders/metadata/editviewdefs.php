<?php
$module_name = 'ODR_SalesOrders';
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
            'name' => 'number',
            'label' => 'LBL_NUMBER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'quote_number',
            'label' => 'LBL_QUOTE_NUMBER',
          ),
          1 => 
          array (
            'name' => 'quote_date',
            'label' => 'LBL_QUOTE_DATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'due_date',
            'label' => 'LBL_DUE_DATE',
          ),
          1 => 
          array (
            'name' => 'invoice_date',
            'label' => 'LBL_INVOICE_DATE',
          ),
        ),
        3 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        4 => 
        array (
          0 => 'description',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'billing_account',
            'studio' => 'visible',
            'label' => 'LBL_BILLING_ACCOUNT',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'billing_contact',
            'studio' => 'visible',
            'label' => 'LBL_BILLING_CONTACT',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'label' => 'LBL_BILLING_ADDRESS_STREET',
          ),
          1 => 
          array (
            'name' => 'shipping_address_street',
            'label' => 'LBL_SHIPPING_ADDRESS_STREET',
          ),
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
          ),
        ),
        1 => 
        array (
          0 => '',
          1 => '',
        ),
        2 => 
        array (
          0 => '',
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'total_amt',
            'label' => 'LBL_TOTAL_AMT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'discount_amount',
            'label' => 'LBL_DISCOUNT_AMOUNT',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'subtotal_amount',
            'label' => 'LBL_SUBTOTAL_AMOUNT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'shipping_amount',
            'label' => 'LBL_SHIPPING_AMOUNT',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'shipping_tax_amt',
            'label' => 'LBL_SHIPPING_TAX_AMT',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'tax_amount',
            'label' => 'LBL_TAX_AMOUNT',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'total_amount',
            'label' => 'LBL_TOTAL_AMOUNT',
          ),
        ),
      ),
    ),
  ),
);
;
?>
