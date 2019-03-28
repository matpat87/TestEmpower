<?php

$dictionary['SAS_SalesActivityStatistics']['fields']['department'] = array(
  'name' => 'department',
  'labelValue' => 'Department',
  'vname' => 'LBL_DEPARTMENT',
  'type' => 'enum',
  'source' => 'non-db',
  'options' => '',
  'function' => 'getDepartmentsForReports',
  'required' => false,
  'massupdate' => '0',
  'default' => NULL,
  'no_default' => false,
  'comments' => '',
  'help' => '',
  'importable' => 'true',
  'duplicate_merge' => 'disabled',
  'duplicate_merge_dom_value' => '0',
  'audited' => false,
  'inline_edit' => true,
  'reportable' => true,
  'unified_search' => false,
  'merge_filter' => 'disabled',
  'len' => '255',
  'size' => '20',
  'quicksearch' => 'enabled',
  'studio' => 'visible',
  'id' => 'SAS_SalesActivityStatisticsdepartment',
);

?>