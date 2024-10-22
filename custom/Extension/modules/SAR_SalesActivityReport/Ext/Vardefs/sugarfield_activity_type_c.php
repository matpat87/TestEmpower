<?php
 // created: 2018-07-23 02:09:26
$dictionary['SAR_SalesActivityReport']['fields']['activity_type_c'] =  array (
    'inline_edit' => '1',
    'labelValue' => 'Activity Type',
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'activity_type_c',
    'vname' => 'LBL_ACTIVITY_TYPE',
    'type' => 'enum',
    'massupdate' => '0',
    'default' => 'All',
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'option' => '',
    'function' => 'SalesActivityReportQuery::retrieveActivityTypeList',
    'studio' => 'visible',
    'dependency' => NULL,
    'id' => 'SAR_SalesActivityReportactivity_type_c'
);

 ?>