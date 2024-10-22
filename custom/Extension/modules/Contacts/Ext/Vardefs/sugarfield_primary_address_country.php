<?php
 // created: 2021-09-28 09:16:15
$dictionary['Contact']['fields']['primary_address_country'] = array (
    'name' => 'primary_address_country',
    'vname' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
    'type' => 'enum',
    'group' => 'billing_address',
    'comment' => 'Country for primary address',
    'merge_filter' => 'disabled',
    'default' => 'US',
    'inline_edit' => '0',
    'required' => true,
    'comments' => 'Country for primary address',
    'options' => 'countries_list',
);

 ?>