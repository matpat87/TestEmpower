<?php
$viewdefs ['Accounts'] = 
array (
  'EditView' => 
  array (
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/Accounts/Account.js',
        ),
        1 => 
        array (
          'file' => 'custom/modules/Accounts/js/custom-edit.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_ACCOUNT_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' => 
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
      'lbl_account_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'phone_office',
            'label' => 'LBL_PHONE_OFFICE',
          ),
          1 => 
          array (
            'name' => 'phone_fax',
            'label' => 'LBL_FAX',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL',
          ),
          1 => 
          array (
            'name' => 'website',
            'type' => 'link',
            'label' => 'LBL_WEBSITE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'sites_c',
            'studio' => 'visible',
            'label' => 'LBL_SITES',
          ),
          1 => 
          array (
            'name' => 'ship_to_company_c',
            'label' => 'LBL_SHIP_TO_COMPANY',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'hideLabel' => true,
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'id' => NULL,
              'key' => 'billing',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
          1 => 
          array (
            'name' => 'shipping_address_street',
            'hideLabel' => true,
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'id' => NULL,
              'key' => 'shipping',
              'copy' => 'billing',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        6 => 
        array (
          0 => 'account_type',
          1 => 
          array (
            'name' => 'parent_name',
            'label' => 'LBL_RELATED_ACCOUNTS_RELATED_ACCT',
            'displayParams' => 
            array (
              'initial_filter' => '&from_module=Accounts&account_type_param=CustomerParent',
            ),
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          1 => 
          array (
            'name' => 'users_accounts_3_name',
            'displayParams' => 
            array (
              'initial_filter' => '&department=CustomerService',
            ),
          ),
        ),
      ),
      'LBL_PANEL_ADVANCED' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'marketing_information_non_db',
            'label' => 'Marketing Information',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'oem_c',
            'studio' => 'visible',
            'label' => 'LBL_OEM',
          ),
          1 => 
          array (
            'name' => 'client_potential_c',
            'studio' => 'visible',
            'label' => 'LBL_CLIENT_POTENTIAL',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'annual_revenue',
            'label' => 'LBL_ANNUAL_REVENUE',
            'customCode' => '<input type="text" name="{$fields.annual_revenue.name}" id="{$fields.annual_revenue.name}" value="{$fields.annual_revenue.value}" onkeypress="return onlyNumberKey(event)" maxlength="{$fields.annual_revenue.len}" class="custom-currency" />',
          ),
          1 => 
          array (
            'name' => 'annual_revenue_potential_c',
            'label' => 'LBL_ANNUAL_REVENUE_POTENTIAL',
            'customCode' => '<input type="text" name="{$fields.annual_revenue_potential_c.name}" id="{$fields.annual_revenue_potential_c.name}" value="{$fields.annual_revenue_potential_c.value}" maxlength="{$fields.annual_revenue_potential_c.len}" class="custom-currency" />',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'manufacturing_type_c',
            'studio' => 'visible',
            'label' => 'LBL_MANUFACTURING_TYPE',
          ),
          1 => 'employees',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'supply_position_c',
            'studio' => 'visible',
            'label' => 'LBL_SUPPLY_POSITION',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
          ),
          1 => 
          array (
            'name' => 'account_class_c',
            'studio' => 'visible',
            'label' => 'LBL_ACCOUNT_CLASS',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'business_strategy_c',
            'studio' => 'visible',
            'label' => 'LBL_BUSINESS_STRATEGY',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'erp_data_non_db',
            'label' => 'ERP Data',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'terms_c',
            'label' => 'LBL_TERMS',
          ),
          1 => 
          array (
            'name' => 'company_no_c',
            'studio' => 'visible',
            'label' => 'LBL_COMPANY_NO',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'cr_limit_c',
            'label' => 'LBL_CR_LIMIT',
          ),
          1 => 
          array (
            'name' => 'cust_num_c',
            'label' => 'LBL_CUST_NUM',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'cr_hold_c',
            'label' => 'LBL_CR_HOLD',
          ),
          1 => 
          array (
            'name' => 'alt_sys_id_c',
            'label' => 'LBL_ALT_SYS_ID',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'balance_c',
            'label' => 'LBL_BALANCE',
          ),
          1 => 
          array (
            'name' => 'order_cycle_c',
            'label' => 'LBL_ORDER_CYCLE',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'last_sale_amt_c',
            'label' => 'LBL_LAST_SALE_AMT',
          ),
          1 => 
          array (
            'name' => 'last_sold_dt_c',
            'label' => 'LBL_LAST_SOLD_DT',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'certification_note_c',
            'studio' => 'visible',
            'label' => 'LBL_CERTIFICATION_NOTE',
          ),
          1 => 
          array (
            'name' => 'color_readings_note_c',
            'studio' => 'visible',
            'label' => 'LBL_COLOR_READINGS_NOTE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'spc_note_c',
            'studio' => 'visible',
            'label' => 'LBL_SPC_NOTE',
          ),
          1 => 
          array (
            'name' => 'probe_note_c',
            'studio' => 'visible',
            'label' => 'LBL_PROBE_NOTE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'post_blend_note_c',
            'studio' => 'visible',
            'label' => 'LBL_POST_BLEND_NOTE',
          ),
          1 => 
          array (
            'name' => 'ash_test_note_c',
            'studio' => 'visible',
            'label' => 'LBL_ASH_TEST_NOTE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'melt_flow_note_c',
            'studio' => 'visible',
            'label' => 'LBL_MELT_FLOW_NOTE',
          ),
          1 => 
          array (
            'name' => 'bulk_density_note_c',
            'studio' => 'visible',
            'label' => 'LBL_BULK_DENSITY_NOTE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'chip_note_c',
            'studio' => 'visible',
            'label' => 'LBL_CHIP_NOTE',
          ),
          1 => 
          array (
            'name' => 'other_note_c',
            'studio' => 'visible',
            'label' => 'LBL_OTHER_NOTE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
