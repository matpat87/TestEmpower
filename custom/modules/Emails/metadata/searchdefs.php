<?php
// created: 2023-03-30 08:57:28
$searchdefs['Emails'] = array (
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
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 
      array (
        'name' => 'imap_keywords',
        'label' => 'LBL_IMAP_KEYWORDS',
        'default' => true,
        'width' => '10%',
      ),
      1 => 
      array (
        'name' => 'from_addr_name',
        'label' => 'LBL_FROM',
        'default' => true,
        'width' => '10%',
      ),
      2 => 
      array (
        'name' => 'to_addrs_names',
        'label' => 'LBL_TO',
        'default' => true,
        'width' => '10%',
      ),
      3 => 
      array (
        'name' => 'name',
        'label' => 'LBL_SUBJECT',
        'default' => true,
        'width' => '10%',
      ),
      4 => 
      array (
        'name' => 'description',
        'label' => 'LBL_BODY',
        'default' => true,
        'width' => '10%',
      ),
      5 => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
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
      6 => 
      array (
        'name' => 'category_id',
        'default' => true,
        'width' => '10%',
      ),
      7 => 
      array (
        'name' => 'parent_name',
        'default' => true,
        'width' => '10%',
      ),
      8 => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
    ),
  ),
);