<?php

  $dictionary["VI_VendorIssues"]["fields"]["times"] = array (
    'name' => 'times',
    'type' => 'link',
    'relationship' => 'vi_vendorissues_times',
    'module' => 'Time',
    'bean_name' => 'Time',
    'source' => 'non-db',
    'vname' => 'LBL_TIMES',
  );

  $dictionary["VI_VendorIssues"]["relationships"]["vi_vendorissues_times"] = array (
    'lhs_module' => 'VI_VendorIssues',
    'lhs_table' => 'vi_vendorissues',
    'lhs_key' => 'id',
    'rhs_module' => 'Time',
    'rhs_table' => 'times',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'VI_VendorIssues',
  );