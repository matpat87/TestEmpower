<?php
  $dictionary["Project"]["fields"]["project_task"] = array (
    'name' => 'project_task',
    'type' => 'link',
    'relationship' => 'project_project_tasks',
    'module' => 'ProjectTask',
    'bean_name' => 'ProjectTask',
    'source' => 'non-db',
    'vname' => 'LBL_PROJECT_TASKS',
  );

  $dictionary["Project"]["relationships"]["project_project_tasks"] = array (
    'lhs_module' => 'Project',
    'lhs_table' => 'project',
    'lhs_key' => 'id',
    'rhs_module' => 'ProjectTask',
    'rhs_table' => 'project_task_cstm',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Project',
  );