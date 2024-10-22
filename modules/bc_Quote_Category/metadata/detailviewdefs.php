<?php

$module_name = 'bc_Quote_Category';
$viewdefs[$module_name]['DetailView'] = array(
    'templateMeta' => array('form' => array('buttons' => array('EDIT', 'DUPLICATE', 'DELETE', 'FIND_DUPLICATES',
            )),
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
    ),
    'panels' => array(
        array(
            'name',
        ),
    )
);
?>
