<?php
 // created: 2021-01-31 10:02:48
$dictionary['AOS_Invoices']['fields']['site_c'] = array (
    'inline_edit' => '',
    'labelValue' => 'Site',
    'required' => true,
    'source' => 'custom_fields',
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
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'site_list',
    'function' => 'get_site_list_dropdown',
    'studio' => 'visible',
    'dependency' => NULL,
    'id' => 'AOS_Invoicessite_c',
);

 ?>