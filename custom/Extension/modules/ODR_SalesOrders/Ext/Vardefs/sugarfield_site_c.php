<?php
// created: 2020-05-23 14:50:09
$dictionary['ODR_SalesOrders']['fields']['site_c'] = array (
    'inline_edit' => '1',
    'labelValue' => 'Site',
    'required' => true,
    //'source' => 'custom_fields',
    'name' => 'site_c',
    'vname' => 'LBL_SITE',
    'type' => 'enum',
    'massupdate' => '0',
    'default' => NULL,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'site_list',
    'function' => 'get_site_list_dropdown',
    'studio' => 'visible',
    'dependency' => NULL,
    //'id' => 'ODR_SalesOrderssite_c',
  );

 ?>