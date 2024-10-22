<?php
// created: 2018-12-09 15:56:54
$layout_defs["Users"]["subpanel_setup"]['tri_technicalrequestitems_assigned_user'] = array (
  'order' => 100,
  'module' => 'TRI_TechnicalRequestItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TRI_TECHNICALREQUESTITEMS_ASSIGNED_USER_FROM_TRI_TECHNICALREQUESTS_TITLE',
  'get_subpanel_data' => 'function:get_assigned_tri_technicalrequestitems',
  'function_parameters' => array(
    'import_function_file' => 'custom/modules/Users/helpers/get_assigned_tri_technicalrequestitems.php',
  ),
  'top_buttons' => 
  array (
   
  ),
);
  


