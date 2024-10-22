<?php
// created: 2023-03-30 08:57:28
$viewdefs['AOS_Invoices']['EditView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'buttons' => 
      array (
        0 => 'SAVE',
        1 => 'CANCEL',
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
      'LBL_PANEL_OVERVIEW' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LBL_INVOICE_TO' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LBL_LINE_ITEMS' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'LBL_PANEL_OVERVIEW' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'number',
          'label' => 'LBL_INVOICE_NUMBER',
          'customCode' => '{$fields.number.value}',
        ),
        1 => 
        array (
          'name' => 'invoice_date',
          'label' => 'LBL_INVOICE_DATE',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'order_number_c',
          'studio' => 'visible',
          'label' => 'LBL_ORDER_NUMBER',
          'customCode' => '<input type="text" name="{$fields.order_number_c.name}" id="{$fields.order_number_c.name}" value="{$fields.order_number_c.value}" maxlength="{$fields.order_number_c.len}" class="custom-readonly" readonly="readonly" />',
        ),
        1 => 
        array (
          'name' => 'status',
          'label' => 'LBL_STATUS',
        ),
      ),
      2 => 
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
      3 => 
      array (
        0 => 
        array (
          'name' => 'users_aos_invoices_1_name',
        ),
        1 => 
        array (
          'name' => 'csr_c',
          'label' => 'LBL_CSR',
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
        1 => 
        array (
          'name' => 'order_date_c',
          'label' => 'LBL_ORDER_DATE',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'requested_date_c',
          'label' => 'LBL_REQUESTED_DATE',
        ),
        1 => 
        array (
          'name' => 'site_c',
          'studio' => 'visible',
          'label' => 'LBL_SITE',
        ),
      ),
      6 => 
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
        1 => 
        array (
          'name' => 'billing_contact',
          'label' => 'LBL_BILLING_CONTACT',
          'displayParams' => 
          array (
            'initial_filter' => '&account_name="+this.form.{$fields.billing_account.name}.value+"',
          ),
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'ship_via_c',
          'label' => 'LBL_SHIP_VIA',
        ),
        1 => 
        array (
          'name' => 'currency_id',
          'studio' => 'visible',
          'label' => 'LBL_CURRENCY',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'erp_id',
          'label' => 'LBL_ERP_ID',
        ),
        1 => '',
      ),
    ),
    'LBL_INVOICE_TO' => 
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
          'hideLabel' => true,
          'type' => 'addressCstm',
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
          'type' => 'addressCstm',
          'displayParams' => 
          array (
            'key' => 'shipping',
            'rows' => 2,
            'cols' => 30,
            'maxlength' => 150,
          ),
          'label' => 'LBL_SHIPPING_ADDRESS_STREET',
        ),
      ),
    ),
    'lbl_line_items' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'line_items',
          'label' => 'LBL_LINE_ITEMS',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'total_amt',
          'label' => 'LBL_TOTAL_AMT',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'total_discount_c',
          'customCode' => '<input type="text" name="{$fields.total_discount_c.name}" 
              id="{$fields.total_discount_c.name}" size="30" maxlength="18" value="{$fields.total_discount_c.value}" title="" tabindex="0" style="max-width: 40%">',
          'label' => 'LBL_TOTAL_DISCOUNT',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'subtotal_amount',
          'label' => 'LBL_SUBTOTAL_AMOUNT',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'misc_amount_c',
          'label' => 'LBL_MISC_AMOUNT',
        ),
      ),
      5 => 
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
      6 => 
      array (
        0 => 
        array (
          'name' => 'tax_amount',
          'label' => 'LBL_TAX_AMOUNT',
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'total_amount',
          'label' => 'LBL_GRAND_TOTAL',
        ),
      ),
    ),
  ),
);