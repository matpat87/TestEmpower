<?php
$searchdefs ['Accounts'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
      'favorites_only' => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      'current_user_only' => 
      array (
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
        'name' => 'current_user_only',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'address_street' => 
      array (
        'name' => 'address_street',
        'label' => 'LBL_ANY_ADDRESS',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'address_city' => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'shipping_address_country' => 
      array (
        'name' => 'shipping_address_country',
        'label' => 'LBL_COUNTRY',
        'type' => 'enum',
        'options' => 'countries_list',
        'default' => true,
        'width' => '10%',
        'displayParams' => 
        array (
          'size' => 1,
        ),
      ),
      'shipping_address_state' => 
      array (
        'name' => 'shipping_address_state',
        'label' => 'LBL_STATE',
        'type' => 'enum',
        'options' => 'states_list',
        'default' => true,
        'width' => '10%',
        'displayParams' => 
        array (
          'size' => 1,
        ),
      ),
      'address_postalcode' => 
      array (
        'name' => 'address_postalcode',
        'label' => 'LBL_POSTAL_CODE',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'account_type' => 
      array (
        'name' => 'account_type',
        'default' => true,
        'width' => '10%',
      ),
      'manufacturing_type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MANUFACTURING_TYPE',
        'width' => '10%',
        'name' => 'manufacturing_type_c',
      ),
      'status_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'name' => 'status_c',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
      'users_accounts_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_USERS_ACCOUNTS_1_FROM_USERS_TITLE',
        'id' => 'USERS_ACCOUNTS_1USERS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'users_accounts_1_name',
        'displayParams' => 
        array (
          'initial_filter' => '&role_c_advanced[]=StrategicAccountManager',
        ),
      ),
      'users_accounts_2_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_USERS_ACCOUNTS_2_FROM_USERS_TITLE',
        'id' => 'USERS_ACCOUNTS_2USERS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'users_accounts_2_name',
        'displayParams' => 
        array (
          'initial_filter' => '&role_c_advanced[]=MarketDevelopmentManager',
        ),
      ),
      'cust_num_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_CUST_NUM',
        'width' => '10%',
        'name' => 'cust_num_c',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
