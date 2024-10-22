<?php
$module_name = 'VEND_Vendors';
$_object_name = 'vend_vendors';
$viewdefs [$module_name] = 
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
          'file' => 'custom/modules/VEND_Vendors/js/edit.js',
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
          0 => 'name',
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 'phone_office',
          1 => 'phone_fax',
        ),
        2 => 
        array (
          0 => 'email1',
          1 => 'website',
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
              'id' => NULL,
              'key' => 'billing',
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
              'copy' => false,
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
              'copy' => false,
              'rows' => 2,
              'cols' => 30,
              'maxlength' => 150,
            ),
          ),
        ),
        4 => 
        array (
          0 => 'description',
          1 => 'vend_vendors_type',
        ),
        5 => 
        array (
          0 => 'assigned_user_name',
          1 => 'rating',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'vp_vendorproducts_vend_vendors_name',
          ),
          1 => '',
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
            'name' => 'sales_channel_c',
            'studio' => 'visible',
            'label' => 'LBL_SALES_CHANNEL',
          ),
          1 => 
          array (
            'name' => 'code_of_conduct_c',
            'studio' => 'visible',
            'label' => 'LBL_CODE_OF_CONDUCT',
          ),
        ),
        2 => 
        array (
          0 => 'ownership',
          1 => 'ticker_symbol',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'minority_owned_c',
            'studio' => 'visible',
            'label' => 'LBL_MINORITY_OWNED',
          ),
          1 => 
          array (
            'name' => 'woman_owned_c',
            'studio' => 'visible',
            'label' => 'LBL_WOMAN_OWNED',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'veteran_owned_c',
            'studio' => 'visible',
            'label' => 'LBL_VETERAN_OWNED',
          ),
          1 => 
          array (
            'name' => 'lgbtq_owned_c',
            'studio' => 'visible',
            'label' => 'LBL_LGBTQ_OWNED',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'small_business_c',
            'studio' => 'visible',
            'label' => 'LBL_SMALL_BUSINESS',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'terms_c',
            'label' => 'LBL_TERMS',
          ),
          1 => 
          array (
            'name' => 'current_balance_c',
            'label' => 'LBL_CURRENT_BALANCE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'ytd_purchases_c',
            'label' => 'LBL_YTD_PURCHASES',
          ),
          1 => 
          array (
            'name' => 'ttm_purchases_c',
            'label' => 'LBL_TTM_PURCHASES',
          ),
        ),
      ),
    ),
  ),
);
;
?>
