<?php
 // created: 2020-07-27 08:29:17
$dictionary['ProjectTask']['fields']['site_c']= array (
    'inline_edit' => '1',
    'labelValue' => 'Site',
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'site_c',
    'vname' => 'LBL_SITE',
    'type' => 'enum',
    'massupdate' => '1',
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
    'dependency' => false,
    'id' => 'ProjectTasksite_c'
);

 ?>