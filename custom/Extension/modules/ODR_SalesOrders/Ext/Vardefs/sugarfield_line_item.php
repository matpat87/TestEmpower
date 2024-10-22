<?php
    $dictionary["ODR_SalesOrders"]["fields"]["line_items"] = array (
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
