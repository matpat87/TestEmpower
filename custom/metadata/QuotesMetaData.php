<?php

// created: 2015-09-03 09:46:28
$dictionary["bc_quote_category_bc_quote"] = array(
    'true_relationship_type' => 'one-to-many',
    'relationships' =>
    array(
        'bc_quote_category_bc_quote' =>
        array(
            'lhs_module' => 'bc_Quote_Category',
            'lhs_table' => 'bc_Quote_Category',
            'lhs_key' => 'id',
            'rhs_module' => 'bc_Quote',
            'rhs_table' => 'bc_Quote',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'bc_quote_category_bc_quote_c',
            'join_key_lhs' => 'bc_quote_category_bc_quotebc_quote_category_ida',
            'join_key_rhs' => 'bc_quote_category_bc_quotebc_quote_idb',
        ),
    ),
    'table' => 'bc_quote_category_bc_quote_c',
    'fields' =>
    array(
        0 =>
        array(
            'name' => 'id',
            'type' => 'varchar',
            'len' => 36,
        ),
        1 =>
        array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        2 =>
        array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ),
        3 =>
        array(
            'name' => 'bc_quote_category_bc_quotebc_quote_category_ida',
            'type' => 'varchar',
            'len' => 36,
        ),
        4 =>
        array(
            'name' => 'bc_quote_category_bc_quotebc_quote_idb',
            'type' => 'varchar',
            'len' => 36,
        ),
    ),
    'indices' =>
    array(
        0 =>
        array(
            'name' => 'bc_quote_category_bc_quotespk',
            'type' => 'primary',
            'fields' =>
            array(
                0 => 'id',
            ),
        ),
        1 =>
        array(
            'name' => 'bc_quote_category_bc_quote_ida1',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'bc_quote_category_bc_quotebc_quote_category_ida',
            ),
        ),
        2 =>
        array(
            'name' => 'bc_quote_category_bc_quote_alt',
            'type' => 'alternate_key',
            'fields' =>
            array(
                0 => 'bc_quote_category_bc_quotebc_quote_idb',
            ),
        ),
    ),
);
