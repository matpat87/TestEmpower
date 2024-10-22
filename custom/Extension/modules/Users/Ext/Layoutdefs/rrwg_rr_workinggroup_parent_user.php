<?php

$layout_defs["Users"]["subpanel_setup"]['rrwg_rr_workinggroup_parent_user'] = array (
  'order' => 4,
  'module' => 'RRWG_RRWorkingGroup',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RRWG_RRWORKINGGROUP_PARENT_USER_TITLE',
  'get_subpanel_data' => 'function:get_parent_user_rrwg_rr_workinggroup',
  'function_parameters' => array(
    'import_function_file' => 'custom/modules/Users/helpers/get_parent_user_rrwg_rr_workinggroup.php',
  ),
  'top_buttons' => 
  array (),
);

  


