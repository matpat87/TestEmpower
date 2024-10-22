<?php
$layout_defs['CI_CustomerItems']['subpanel_setup']['get_invoices'] =
array('order' => 40,
    'module' => 'AOS_Invoices',
    'subpanel_name' => 'CI_CustomerItems_Invoices',
    'get_subpanel_data' => 'function:get_invoices',
    //'generate_select' => true,
    'title_key' => 'Invoices',
    'top_buttons' => array(),
    //'generate_select' => true,
    //'get_distinct_data' => true,
    'function_parameters' => array(
        'import_function_file' => 'custom/modules/CI_CustomerItems/get_invoices.php',
        'id' => $this->_focus->id,
        'module' => 'AOS_Invoices'
        //'return_as_array' => 'true'
    ),
);
?>