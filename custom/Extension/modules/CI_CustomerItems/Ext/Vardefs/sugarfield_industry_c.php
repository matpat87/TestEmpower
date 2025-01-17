<?php
 // created: 2020-09-02 08:59:39
$dictionary['CI_CustomerItems']['fields']['industry_c'] = array (
    'inline_edit' => '1',
    'labelValue' => 'Industry',
    'required' => true,
    'source' => 'custom_fields',
    'name' => 'industry_c',
    'vname' => 'LBL_INDUSTRY',
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
    'options' => 'industry_dom',
    'function' => 'get_industries_dropdown',
    'studio' => 'visible',
    'dependency' => false,
    'id' => 'CI_CustomerItemsindustry_c',
);
 ?>