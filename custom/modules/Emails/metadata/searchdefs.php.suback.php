<?php
$module_name = 'Emails';
$searchdefs [$module_name] = 
array (
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
      'imap_keywords' => 
      array (
        'name' => 'imap_keywords',
        'label' => 'LBL_IMAP_KEYWORDS',
        'default' => true,
        'width' => '10%',
      ),
      'from_addr_name' => 
      array (
        'name' => 'from_addr_name',
        'label' => 'LBL_FROM',
        'default' => true,
        'width' => '10%',
      ),
      'to_addrs_names' => 
      array (
        'name' => 'to_addrs_names',
        'label' => 'LBL_TO',
        'default' => true,
        'width' => '10%',
      ),
      'name' => 
      array (
        'name' => 'name',
        'label' => 'LBL_SUBJECT',
        'default' => true,
        'width' => '10%',
      ),
      'description' => 
      array (
        'name' => 'description',
        'label' => 'LBL_BODY',
        'default' => true,
        'width' => '10%',
      ),
      'assigned_user_id' => 
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
      'category_id' => 
      array (
        'name' => 'category_id',
        'default' => true,
        'width' => '10%',
      ),
      'parent_name' => 
      array (
        'name' => 'parent_name',
        'default' => true,
        'width' => '10%',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
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
