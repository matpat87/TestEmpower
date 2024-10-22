<?php

$dictionary["Case"]["fields"]["times"] = array (
    'name' => 'times',
    'type' => 'link',
    'relationship' => 'case_times',
    'module' => 'Time',
    'bean_name' => 'Time',
    'source' => 'non-db',
    'vname' => 'LBL_TIMES',
  );

  $dictionary["Case"]["relationships"]["case_times"] = array (
    'lhs_module' => 'Cases',
    'lhs_table' => 'cases',
    'lhs_key' => 'id',
    'rhs_module' => 'Time',
    'rhs_table' => 'times',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Cases',
  );