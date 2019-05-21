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
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'number',
            'label' => 'LBL_NUMBER',
            'customCode' => '{$fields.number.value}',
          ),
          1 => 
          array (
            'name' => 'po_number_c',
            'label' => 'LBL_PO_NUMBER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'order_type_c',
            'studio' => 'visible',
            'label' => 'LBL_ORDER_TYPE',
          ),
          1 => 
          array (
            'name' => 'order_date_c',
            'label' => 'LBL_ORDER_DATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'ship_via_c',
            'label' => 'LBL_SHIP_VIA',
          ),
          1 => 
          array (
            'name' => 'shipped_date_c',
            'label' => 'LBL_SHIPPED_DATE',
          ),
        ),
        3 => 
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
        4 => 
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
        5 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        6 => 
        array (
          0 => 'description',
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'billing_account',
            'label' => 'LBL_BILLING_ACCOUNT',
            'displayParams' => 
            array (
              'key' => 
              array (
                0 => 'billing',
                1 => 'shipping',
              ),
              'copy' => 
              array (
                0 => 'billing',
                1 => 'shipping',
              ),
              'billingKey' => 'billing',
              'shippingKey' => 'shipping',
            ),
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'billing_contact',
            'label' => 'LBL_BILLING_CONTACT',
            'displayParams' => 
            array (
              'initial_filter' => '&account_name="+this.form.{$fields.billing_account.name}.value+"',
            ),
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' => 
            array (
              'key' => 'billing',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
            'label' => 'LBL_BILLING_ADDRESS_STREET',
          ),
          1 => 
          array (
            'name' => 'shipping_address_street',
            'hideLabel' => true,
            'type' => 'address',
            'displayParams' => 
            array (
              'key' => 'shipping',
              'copy' => 'billing',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
            'label' => 'LBL_SHIPPING_ADDRESS_STREET',
          ),
        ),
      ),
      'lbl_editview_panel3' => 
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
          0 => 
          array (
            'name' => 'line_items',
            'label' => 'LBL_LINE_ITEMS',
          ),
        ),
        2 => 
        array (
          0 => '',
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
            'displayParams' => 
            array (
              'field' => 
              array (
                'onblur' => 'calculateTotal(\'lineItems\');',
              ),
            ),
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
            'displayParams' => 
            array (
              'field' => 
              array (
                'onblur' => 'calculateTotal(\'lineItems\');',
              ),
            ),
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'tax_amount',
            'label' => 'LBL_TAX_AMOUNT',
          ),
        ),
        8 => 
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
