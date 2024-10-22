<?php
 // created: 2020-11-23 07:58:18
$dictionary['RMM_RawMaterialMaster']['fields']['product_category_c'] = array (
    'inline_edit' => '1',
    'labelValue' => 'Product Category',
    'function' => 'get_product_categories',
    'required' => true,
    'source' => 'custom_fields',
    'name' => 'product_category_c',
    'vname' => 'LBL_PRODUCT_CATEGORY',
    'type' => 'enum',
    'massupdate' => '0',
    'default' => '',
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
    'studio' => 'visible',
    'dependency' => false,
    'id' => 'RMM_RawMaterialMasterproduct_category_c'
);

 ?>