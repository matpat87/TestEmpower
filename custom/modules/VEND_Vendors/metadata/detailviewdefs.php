<?php
$module_name = 'VEND_Vendors';
$_object_name = 'vend_vendors';
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
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_ACCOUNT_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'lbl_account_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'vendor_number_c',
            'label' => 'LBL_VENDOR_NUMBER',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 'phone_office',
          1 => 'phone_fax',
        ),
        3 => 
        array (
          0 => 'email1',
          1 => 'website',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'label' => 'LBL_BILLING_ADDRESS',
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'key' => 'billing',
            ),
          ),
          1 => 
          array (
            'name' => 'shipping_address_street',
            'label' => 'LBL_SHIPPING_ADDRESS',
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'key' => 'shipping',
            ),
          ),
        ),
        5 => 
        array (
          0 => 'description',
          1 => 'vend_vendors_type',
        ),
        6 => 
        array (
          0 => 'assigned_user_name',
          1 => 'rating',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'vp_vendorproducts_vend_vendors_name',
          ),
          1 => '',
        ),
      ),
      'lbl_detailview_panel3' => 
      array (
        0 => 
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
        1 => 
        array (
          0 => 'ownership',
          1 => 'ticker_symbol',
        ),
        2 => 
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
        3 => 
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
        4 => 
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
      'lbl_editview_panel2' => 
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
