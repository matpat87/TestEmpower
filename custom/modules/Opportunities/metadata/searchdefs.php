<?php
// created: 2023-03-30 08:57:28
$searchdefs['Opportunities'] = array (
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
      0 => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
      2 => 
      array (
        'name' => 'open_only',
        'label' => 'LBL_OPEN_ITEMS',
        'type' => 'bool',
        'default' => false,
        'width' => '10%',
      ),
      3 => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 
      array (
        'type' => 'int',
        'default' => true,
        'label' => 'LBL_OPPID',
        'width' => '10%',
        'name' => 'oppid_c',
      ),
      1 => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      2 => 
      array (
        'name' => 'account_name',
        'default' => true,
        'width' => '10%',
      ),
      3 => 
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
      4 => 
      array (
        'name' => 'sales_stage',
        'default' => true,
        'width' => '10%',
      ),
      5 => 
      array (
        'name' => 'lead_source',
        'default' => true,
        'width' => '10%',
      ),
      6 => 
      array (
        'name' => 'amount',
        'default' => true,
        'width' => '10%',
      ),
      7 => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SUB_INDUSTRY',
        'width' => '10%',
        'name' => 'sub_industry_c',
      ),
      8 => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_INDUSTRY',
        'width' => '10%',
        'name' => 'industry_c',
      ),
      9 => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MARKET',
        'width' => '10%',
        'name' => 'market_c',
      ),
      10 => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
      11 => 
      array (
        'name' => 'date_closed',
        'default' => true,
        'width' => '10%',
      ),
      12 => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_NEXT_STEP',
        'width' => '10%',
        'default' => true,
        'name' => 'next_step',
      ),
    ),
  ),
);