<?php
 // created: 2019-01-13 16:23:47
$dictionary['Lead']['fields']['last_name'] =  array (
    'name' => 'last_name',
    'vname' => 'LBL_LAST_NAME',
    'type' => 'varchar',
    'len' => '100',
    'unified_search' => true,
    'full_text_search' => 
    array (
        'boost' => 3,
    ),
    'comment' => 'Last name of the contact',
    'merge_filter' => 'disabled',
    'required' => false,
    'importable' => 'required',
    'inline_edit' => true,
    'comments' => 'Last name of the contact'
    );
 ?>