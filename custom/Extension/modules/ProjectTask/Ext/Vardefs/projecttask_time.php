<?php

  $dictionary["ProjectTask"]["fields"]["times"] = array (
    'name' => 'times',
    'type' => 'link',
    'relationship' => 'projecttask_times',
    'module' => 'Time',
    'bean_name' => 'Time',
    'source' => 'non-db',
    'vname' => 'LBL_TIMES',
  );

  $dictionary["ProjectTask"]["relationships"]["projecttask_times"] = array (
    'lhs_module' => 'ProjectTask',
    'lhs_table' => 'project_task',
    'lhs_key' => 'id',
    'rhs_module' => 'Time',
    'rhs_table' => 'times',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'ProjectTask',
  );