<?php

$layout_defs["Users"]["subpanel_setup"]['dsbtn_distributionitems_assigned_user'] = array (
  'order' => 3,
  'module' => 'DSBTN_DistributionItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DSBTN_DISTRIBUTIONITEMS_ASSIGNED_USER_TITLE',
  'get_subpanel_data' => 'function:get_assigned_dsbtn_distributionitems',
  'function_parameters' => array(
    'import_function_file' => 'custom/modules/Users/helpers/get_assigned_dsbtn_distributionitems.php',
  ),
  'top_buttons' => 
  array (
   
  ),
);

  


