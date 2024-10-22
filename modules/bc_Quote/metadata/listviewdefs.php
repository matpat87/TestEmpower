<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');





$module_name = 'bc_Quote';
$listViewDefs[$module_name] = array(
    'NAME' => array(
        'width' => '30',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true),
    'B_QUOTE_CATEGORY_B_QUOTE_NAME' => array(
        'width' => '50',
        'label' => 'LBL_BC_QUOTE_CATEGORY_BC_QUOTE_FROM_BC_QUOTE_CATEGORY_TITLE',
        'default' => true),
);
?>
