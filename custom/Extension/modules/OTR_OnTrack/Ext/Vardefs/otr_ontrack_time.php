<?php

  $dictionary["OTR_OnTrack"]["fields"]["times"] = array (
    'name' => 'times',
    'type' => 'link',
    'relationship' => 'otr_ontrack_times',
    'module' => 'Time',
    'bean_name' => 'Time',
    'source' => 'non-db',
    'vname' => 'LBL_TIMES',
  );

  $dictionary["OTR_OnTrack"]["relationships"]["otr_ontrack_times"] = array (
    'lhs_module' => 'OTR_OnTrack',
    'lhs_table' => 'otr_ontrack',
    'lhs_key' => 'id',
    'rhs_module' => 'Time',
    'rhs_table' => 'times',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'OTR_OnTrack',
  );