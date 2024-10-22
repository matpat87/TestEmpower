<?php
  $dictionary['DSBTN_Distribution']['fields']['alt_address_state'] = array (
    'name' => 'alt_address_state',
    'vname' => 'LBL_ALT_ADDRESS_STATE',
    'source' => 'custom_fields',
    'type' => 'enum',
    'len' => '100',
    'group' => 'billing_address',
    'comment' => 'State for alternate address',
    'merge_filter' => 'enabled',
    'comments' => 'State for alternate address',
    'options' => 'states_list',
    'inline_edit' => '0',
    'massupdate' => '0',
  );
?>