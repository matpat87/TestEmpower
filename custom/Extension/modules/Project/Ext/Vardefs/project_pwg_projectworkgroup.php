<?php

  $dictionary["Project"]["fields"]["pwg_projectworkgroup"] = array (
    'name' => 'pwg_projectworkgroup',
    'type' => 'link',
    'relationship' => 'project_pwg_projectworkgroups',
    'module' => 'PWG_ProjectWorkgroup',
    'bean_name' => 'PWG_ProjectWorkgroup',
    'source' => 'non-db',
    'vname' => 'LBL_PROJECT_WORKGROUP_SUBPANEL_TITLE',
  );

  $dictionary["Project"]["relationships"]["project_pwg_projectworkgroups"] = array (
    'lhs_module' => 'Project',
    'lhs_table' => 'project',
    'lhs_key' => 'id',
    'rhs_module' => 'PWG_ProjectWorkgroup',
    'rhs_table' => 'pwg_projectworkgroup',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'Project',
  );