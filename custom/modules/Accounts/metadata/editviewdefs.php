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
            'name' => 'phone_office',
            'label' => 'LBL_PHONE_OFFICE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'website',
            'type' => 'link',
            'label' => 'LBL_WEBSITE',
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
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'hideLabel' => true,
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
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
              'key' => 'shipping',
              'copy' => 'billing',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        5 => 
        array (
          0 => 'account_type',
          1 => 'parent_name',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          1 => 
          array (
            'name' => 'mkt_markets_accounts_1_name',
          ),
        ),
      ),
      'LBL_PANEL_ADVANCED' => 
      array (
        0 => 
        array (
          0 => 'annual_revenue',
          1 => 'employees',
        ),
        1 => 
        array (
          0 => 'industry',
          1 => 'campaign_name',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'order_cycle_c',
            'label' => 'LBL_ORDER_CYCLE',
          ),
          1 => 
          array (
            'name' => 'cr_hold_c',
            'label' => 'LBL_CR_HOLD',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'oem_c',
            'studio' => 'visible',
            'label' => 'LBL_OEM',
          ),
          1 => 
          array (
            'name' => 'manufacturing_type_c',
            'studio' => 'visible',
            'label' => 'LBL_MANUFACTURING_TYPE',
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
