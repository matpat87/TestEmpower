<?php
$layout_defs['CI_CustomerItems']['subpanel_setup']['get_orders'] =
array('order' => 40,
    'module' => 'ODR_SalesOrders',
    'subpanel_name' => 'CI_CustomerItems_Orders',
    'get_subpanel_data' => 'function:get_orders',
    //'generate_select' => true,
    'title_key' => 'Orders',
    'top_buttons' => array(),
    //'generate_select' => true,
    //'get_distinct_data' => true,
    'function_parameters' => array(
        'import_function_file' => 'custom/modules/CI_CustomerItems/get_orders.php',
        'id' => $this->_focus->id,
        //'return_as_array' => 'true'
    ),
);
?>