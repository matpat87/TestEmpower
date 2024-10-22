<?php

  $dictionary["PWG_ProjectWorkgroup"]["fields"]["project_task"] = array (
    'name' => 'project_task',
    'type' => 'link',
    'relationship' => 'projectworkgroup_project_tasks',
    'module' => 'ProjectTask',
    'bean_name' => 'ProjectTask',
    'source' => 'non-db',
    'vname' => 'LBL_PROJECT_TASKS',
  );

  $dictionary["PWG_ProjectWorkgroup"]["relationships"]["projectworkgroup_project_tasks"] = array (
    'lhs_module' => 'PWG_ProjectWorkgroup',
    'lhs_table' => 'pwg_projectworkgroup',
    'lhs_key' => 'id',
    'rhs_module' => 'ProjectTask',
    'rhs_table' => 'project_task_cstm',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'PWG_ProjectWorkgroup',
  );