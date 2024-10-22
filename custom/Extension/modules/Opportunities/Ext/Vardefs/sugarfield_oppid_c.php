<?php
  $dictionary['Opportunity']['fields']['oppid_c'] = array(
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'oppid_c',
    'vname' => 'LBL_OPPID',
    'type' => 'int',
    'massupdate' => '0',
    'default' => NULL,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'inline_edit' => false,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'disabled',
    'len' => '6',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => NULL,
    'min' => 1,
    'max' => 999999,
    'validation' => 
    array (
      'type' => 'range',
      'min' => 1,
      'max' => 999999,
    ),
    'id' => 'Opportunitiesoppid_c',
  );
?>