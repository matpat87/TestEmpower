<?php

$layout_defs["Users"]["subpanel_setup"]['trwg_tr_workinggroup_parent_user'] = array (
  'order' => 3,
  'module' => 'TRWG_TRWorkingGroup',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TRWG_TRWORKINGGROUP_PARENT_USER_TITLE',
  'get_subpanel_data' => 'function:get_parent_user_trwg_tr_workinggroup',
  'function_parameters' => array(
    'import_function_file' => 'custom/modules/Users/helpers/get_parent_user_trwg_tr_workinggroup.php',
  ),
  'top_buttons' => 
  array (),
);

  


