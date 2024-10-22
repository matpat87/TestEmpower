<?php
$module_name = 'ODR_SalesOrders';
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
          4 => 
          array (
            'customCode' => '<input type="button" class="button" onClick="showPopup(\'pdf\');" value="{$MOD.LBL_PRINT_AS_PDF}">',
          ),
          5 => 
          array (
            'customCode' => '<input type="button" class="button" onClick="showPopup(\'emailpdf\');" value="{$MOD.LBL_EMAIL_PDF}">',
          ),
          6 => 
          array (
            'customCode' => '<input type="button" class="button" onClick="showPopup(\'email\');" value="{$MOD.LBL_EMAIL_INVOICE}">',
          ),
        ),
      ),
      'includes' => array(
        0 => array (
          'file' => 'custom/modules/ODR_SalesOrders/js/list.js',
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
            'name' => 'order_type_c',
            'studio' => 'visible',
            'label' => 'LBL_ORDER_TYPE',
          ),
          1 => 
          array (
            'name' => 'po_number_c',
            'label' => 'LBL_PO_NUMBER',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'salesperson_c',
          ),
          1 => 
          array (
            'name' => 'csr_c',
            'studio' => 'visible',
            'label' => 'LBL_CSR',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'discount_amount',
            'label' => 'LBL_DISCOUNT_AMOUNT',
          ),
          1 => 
          array (
            'name' => 'order_date_c',
            'label' => 'LBL_ORDER_DATE',
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
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'accounts_odr_salesorders_1_name',
          ),
          1 => 
          array (
            'name' => 'contacts_odr_salesorders_1_name',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'ship_via_c',
            'label' => 'LBL_SHIP_VIA',
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
            'name' => 'bill_to_c',
            'label' => 'LBL_BILL_TO',
          ),
          1 => 
          array (
            'name' => 'company_c',
            'label' => 'LBL_COMPANY',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'label' => 'LBL_BILLING_ADDRESS',
            'type' => 'addressCstm',
            'displayParams' => 
            array (
              'key' => 'billing',
            ),
          ),
          1 => 
          array (
            'name' => 'shipping_address_street',
            'label' => 'LBL_SHIPPING_ADDRESS',
            'type' => 'addressCstm',
            'displayParams' => 
            array (
              'key' => 'shipping',
            ),
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
          0 => '',
          1 => 
          array (
            'name' => 'subtotal_amount',
            'type' => 'varchar',
            'label' => 'LBL_SUBTOTAL_AMOUNT',
          ),
        ),
        4 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'misc_amount_c',
            'type' => 'varchar',
            'label' => 'LBL_MISC_AMOUNT',
          ),
        ),
        5 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'shipping_amount',
            'type' => 'varchar',
            'label' => 'LBL_SHIPPING_AMOUNT',
          ),
        ),
        6 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'tax_amount',
            'type' => 'varchar',
            'label' => 'LBL_TAX_AMOUNT',
          ),
        ),
        7 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'total_amount',
            'type' => 'varchar',
            'label' => 'LBL_TOTAL_AMOUNT',
          ),
        ),
      ),
    ),
  ),
);
;
?>
