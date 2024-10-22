<?php
 // created: 2020-11-18 01:52:57
$dictionary['Document']['fields']['parent_id'] = array (
    'name' => 'parent_id',
    'vname' => 'LBL_LIST_RELATED_TO_ID',
    'type' => 'id',
    'group' => 'parent_name',
    'reportable' => false,
    'comment' => 'The ID of the parent Sugar object identified by parent_type',
);
$dictionary['Document']['fields']['parent_name'] = array (
    'name' => 'parent_name',
    'parent_type' => 'record_type_display',
    'type_name' => 'parent_type',
    'id_name' => 'parent_id',
    'vname' => 'LBL_LIST_RELATED_TO',
    'type' => 'parent',
    'group' => 'parent_name',
    'source' => 'non-db',
    'options' => 'documents_dynamic_parent_type',
    // 'function' => 'get_dynamic_documents_related_to',
    'required' => true,
);
$dictionary['Document']['fields']['parent_type'] = array (
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'parent_type',
    'dbType' => 'varchar',
    'required' => true,
    'group' => 'parent_name',
    'options' => 'documents_dynamic_parent_type',
    // 'function' => 'getDynamicDocumentsRelatedTo',
    'len' => 255,
    'comment' => 'The Sugar object to which the call is related',
    'inline_edit' => true,
    'comments' => 'The Sugar object to which the call is related',
    'merge_filter' => 'disabled',
);

