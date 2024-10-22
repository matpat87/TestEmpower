<?php
$dashletData['AccountsDashlet']['searchFields'] = array (
  'last_activity_date_c' => 
  array (
    'default' => 'TP_no_update_last_90_days',
    'label' => 'LBL_NO_ACTIVITY',
  ),
  'date_entered' => 
  array (
    'default' => '',
  ),
  'account_type' => 
  array (
    'default' => '',
  ),
  'billing_address_country' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'default' => '',
  ),
);
$dashletData['AccountsDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'account_type' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
    'name' => 'account_type',
  ),
  'billing_address_city' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_CITY',
    'name' => 'billing_address_city',
    'default' => true,
  ),
  'billing_address_state' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_STATE',
    'name' => 'billing_address_state',
    'default' => true,
  ),
  'sls_ly_c' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SLS_LY',
    'name' => 'sls_ly_c',
    'default' => true,
  ),
  'last_activity_date_c' => 
  array (
    'type' => 'datetimecombo',
    'default' => true,
    'label' => 'LBL_LAST_ACTIVITY_DATE',
    'width' => '10%',
    'defaultOrderColumn' => 
    array (
      'sortOrder' => 'ASC',
    ),
    'name' => 'last_activity_date_c',
  ),
  'last_activity_type_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_LAST_ACTIVITY_TYPE',
    'width' => '10%',
  ),
  'phone_fax' => 
  array (
    'width' => '8%',
    'label' => 'LBL_PHONE_FAX',
    'name' => 'phone_fax',
    'default' => false,
  ),
  'billing_address_country' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'default' => false,
    'name' => 'billing_address_country',
  ),
  'phone_alternate' => 
  array (
    'width' => '8%',
    'label' => 'LBL_OTHER_PHONE',
    'name' => 'phone_alternate',
    'default' => false,
  ),
  'phone_office' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_PHONE',
    'default' => false,
    'name' => 'phone_office',
  ),
  'website' => 
  array (
    'width' => '8%',
    'label' => 'LBL_WEBSITE',
    'default' => false,
    'name' => 'website',
  ),
  'billing_address_street' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_STREET',
    'name' => 'billing_address_street',
    'default' => false,
  ),
  'billing_address_postalcode' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'name' => 'billing_address_postalcode',
    'default' => false,
  ),
  'shipping_address_city' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'name' => 'shipping_address_city',
    'default' => false,
  ),
  'shipping_address_street' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'name' => 'shipping_address_street',
    'default' => false,
  ),
  'shipping_address_state' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
    'name' => 'shipping_address_state',
    'default' => false,
  ),
  'shipping_address_postalcode' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'name' => 'shipping_address_postalcode',
    'default' => false,
  ),
  'shipping_address_country' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'name' => 'shipping_address_country',
    'default' => false,
  ),
  'email1' => 
  array (
    'width' => '8%',
    'label' => 'LBL_EMAIL_ADDRESS_PRIMARY',
    'name' => 'email1',
    'default' => false,
  ),
  'parent_name' => 
  array (
    'width' => '15%',
    'label' => 'LBL_MEMBER_OF',
    'sortable' => false,
    'name' => 'parent_name',
    'default' => false,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'name' => 'date_entered',
    'default' => false,
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
);
