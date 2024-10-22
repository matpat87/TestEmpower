<?php
  $dictionary['DSBTN_Distribution']['fields']['primary_address_state'] = array (
    'name' => 'primary_address_state',
    'vname' => 'LBL_PRIMARY_ADDRESS_STATE',
    'source' => 'custom_fields',
    'type' => 'enum',
    'len' => '100',
    'group' => 'billing_address',
    'comment' => 'State for primary address',
    'merge_filter' => 'enabled',
    'comments' => 'State for primary address',
    'options' => 'states_list',
    'inline_edit' => '0',
    'massupdate' => '0',
  );
?>