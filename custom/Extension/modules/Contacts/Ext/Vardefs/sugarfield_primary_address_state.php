<?php
 // created: 2021-09-22 05:13:02
$dictionary['Contact']['fields']['primary_address_state'] = array (
    'name' => 'primary_address_state',
    'vname' => 'LBL_PRIMARY_ADDRESS_STATE',
    'type' => 'enum',
    'len' => '100',
    'group' => 'billing_address',
    'comment' => 'State for primary address',
    'merge_filter' => 'disabled',
    'comments' => 'State for primary address',
    'options' => 'states_list',
    'inline_edit' => '',
    'required' => true,
);

?>