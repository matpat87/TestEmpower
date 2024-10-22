<?php

// created: 2015-09-03 09:46:28
$dictionary["bc_Quote"]["fields"]["bc_quote_category_bc_quote"] = array(
    'name' => 'bc_quote_category_bc_quote',
    'type' => 'link',
    'relationship' => 'bc_quote_category_bc_quote',
    'source' => 'non-db',
    'module' => 'bc_Quote_Category',
    'bean_name' => 'bc_Quote_Category',
    'vname' => 'LBL_BC_QUOTE_CATEGORY_BC_QUOTE_FROM_BC_QUOTE_CATEGORY_TITLE',
    'id_name' => 'bc_quote_category_bc_quotebc_quote_category_ida',
);
$dictionary["bc_Quote"]["fields"]["bc_quote_category_bc_quote_name"] = array(
    'name' => 'bc_quote_category_bc_quote_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_BC_QUOTE_CATEGORY_BC_QUOTE_FROM_BC_QUOTE_CATEGORY_TITLE',
    'save' => true,
    'id_name' => 'bc_quote_category_bc_quotebc_quote_category_ida',
    'link' => 'bc_quote_category_bc_quote',
    'table' => 'bc_Quote_Category',
    'module' => 'bc_Quote_Category',
    'rname' => 'name',
);
$dictionary["bc_Quote"]["fields"]["bc_quote_category_bc_quotebc_quote_category_ida"] = array(
    'name' => 'bc_quote_category_bc_quotebc_quote_category_ida',
    'type' => 'link',
    'relationship' => 'bc_quote_category_bc_quote',
    'source' => 'non-db',
    'reportable' => false,
    'side' => 'right',
    'vname' => 'LBL_BC_QUOTE_CATEGORY_BC_QUOTE_FROM_BC_QUOTE_TITLE',
);
