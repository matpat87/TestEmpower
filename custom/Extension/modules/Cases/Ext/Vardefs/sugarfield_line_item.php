<?php
$dictionary["Case"]["fields"]["line_items"] = array (
    'required' => false,
    'name' => 'line_items',
    'vname' => 'LBL_LINE_ITEMS',
    'type' => 'function',
    'source' => 'non-db',
    'massupdate' => 0,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => false,
    'inline_edit' => false,
    'function' =>
        array(
            'name' => 'display_lines',
            'returns' => 'html',
            'include' => 'modules/AOS_Products_Quotes/Line_Items.php'
        ),
);

// Link to bind Parent Type dropdown field from AOS_Products_Quotes
$dictionary["Case"]["fields"]["aos_products_quotes"] = array (
    'name' => 'aos_products_quotes',
    'vname' => 'LBL_AOS_PRODUCT_QUOTES',
    'type' => 'link',
    'relationship' => 'cases_aos_products_quotes',
    'module' => 'AOS_Products_Quotes',
    'bean_name' => 'AOS_Products_Quotes',
    'source' => 'non-db',
);

$dictionary["Case"]["relationships"]["cases_aos_products_quotes"] = array (
    'lhs_module' => 'Cases',
    'lhs_table' => 'cases',
    'lhs_key' => 'id',
    'rhs_module' => 'AOS_Products_Quotes',
    'rhs_table' => 'aos_products_quotes',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
);

$dictionary["Case"]["fields"]["aos_line_item_groups"] = array (
    'name' => 'aos_line_item_groups',
    'vname' => 'LBL_AOS_LINE_ITEM_GROUPS',
    'type' => 'link',
    'relationship' => 'cases_aos_line_item_groups',
    'module' => 'AOS_Line_Item_Groups',
    'bean_name' => 'AOS_Line_Item_Groups',
    'source' => 'non-db',
);

$dictionary["Case"]["relationships"]["cases_aos_line_item_groups"] = array (
    'lhs_module' => 'Cases',
    'lhs_table' => 'cases',
    'lhs_key' => 'id',
    'rhs_module' => 'AOS_Line_Item_Groups',
    'rhs_table' => 'aos_line_item_groups',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
);