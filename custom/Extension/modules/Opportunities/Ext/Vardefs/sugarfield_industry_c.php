<?php
 // created: 2021-08-12 08:26:37
$dictionary['Opportunity']['fields']['industry_c'] = array (
    'inline_edit' => '1',
    'labelValue' => 'Industry',
    'required' => true,
    'source' => 'custom_fields',
    'name' => 'industry_c',
    'vname' => 'LBL_INDUSTRY',
    'type' => 'enum',
    'massupdate' => '0',
    'default' => '',
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
    'id' => 'Opportunitiesindustry_c',
);

 ?>