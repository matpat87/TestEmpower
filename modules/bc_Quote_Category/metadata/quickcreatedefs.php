<?php

$module_name = 'bc_Quote_Category';
$viewdefs[$module_name]['QuickCreate'] = array(
    'templateMeta' => array('maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
    ),
    'panels' => array(
        'default' =>
        array(
            array(
                'name',
            ),
        ),
    ),
);
?>
