<?php
$popupMeta = array (
    'moduleMain' => 'DSBTN_Distribution',
    'varName' => 'DSBTN_Distribution',
    'orderBy' => 'dsbtn_distribution.name',
    'whereClauses' => array (
  'distribution_number_c' => 'dsbtn_distribution_cstm.distribution_number_c',
  'custom_technical_request_number_non_db' => 'dsbtn_distribution.custom_technical_request_number_non_db',
  'account_c' => 'dsbtn_distribution.account_c',
  'contact_c' => 'dsbtn_distribution.contact_c',
),
    'searchInputs' => array (
  4 => 'distribution_number_c',
  5 => 'custom_technical_request_number_non_db',
  6 => 'account_c',
  7 => 'contact_c',
),
    'searchdefs' => array (
  'distribution_number_c' => 
  array (
    'type' => 'int',
    'label' => 'LBL_DISTRIBUTION_NUMBER',
    'width' => '10%',
    'name' => 'distribution_number_c',
  ),
  'custom_technical_request_number_non_db' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TECHNICAL_REQUEST_NUMBER',
    'width' => '10%',
    'name' => 'custom_technical_request_number_non_db',
  ),
  'account_c' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => '10%',
    'name' => 'account_c',
  ),
  'contact_c' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_CONTACT',
    'id' => 'CONTACT_ID_C',
    'link' => true,
    'width' => '10%',
    'name' => 'contact_c',
  ),
),
    'listviewdefs' => array (
  'DISTRIBUTION_NUMBER_C' => 
  array (
    'type' => 'int',
    'default' => true,
    'label' => 'LBL_DISTRIBUTION_NUMBER',
    'width' => '10%',
    'link' => true,
    'name' => 'distribution_number_c',
  ),
  'CUSTOM_TECHNICAL_REQUEST_NUMBER_NON_DB' => 
  array (
    'type' => 'relate',
    'default' => true,
    'label' => 'LBL_TECHNICAL_REQUEST_NUMBER',
    'width' => '10%',
    'studio' => 'visible',
    'name' => 'custom_technical_request_number_non_db',
  ),
  'CUSTOM_TECHNICAL_REQUEST_VERSION_NON_DB' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_TECHNICAL_REQUEST_VERSION',
    'width' => '10%',
    'studio' => 'visible',
    'name' => 'custom_technical_request_version_non_db',
  ),
  'ACCOUNT_C' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'width' => '10%',
    'name' => 'account_c',
  ),
  'CONTACT_C' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_CONTACT',
    'id' => 'CONTACT_ID_C',
    'width' => '10%',
    'name' => 'contact_c',
  ),
  'CUSTOM_TOTAL_ITEMS_NON_DB' => 
  array (
    'type' => 'int',
    'default' => true,
    'label' => 'LBL_TOTAL_ITEMS',
    'width' => '10%',
    'name' => 'custom_total_items_non_db',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
    'name' => 'date_entered',
  ),
),
);
