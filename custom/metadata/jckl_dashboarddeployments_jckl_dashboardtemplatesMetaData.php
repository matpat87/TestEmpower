<?php
// created: 2016-09-03 05:37:17
$dictionary["jckl_dashboarddeployments_jckl_dashboardtemplates"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'jckl_dashboarddeployments_jckl_dashboardtemplates' => 
    array (
      'lhs_module' => 'jckl_DashboardTemplates',
      'lhs_table' => 'jckl_dashboardtemplates',
      'lhs_key' => 'id',
      'rhs_module' => 'jckl_DashboardDeployments',
      'rhs_table' => 'jckl_dashboarddeployments',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'jckl_dashboarddeployments_jckl_dashboardtemplates_c',
      'join_key_lhs' => 'jckl_dashboardtemplates_ida',
      'join_key_rhs' => 'jckl_dashboarddeployments_idb',
    ),
  ),
  'table' => 'jckl_dashboarddeployments_jckl_dashboardtemplates_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'jckl_dashboardtemplates_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'jckl_dashboarddeployments_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'jckl_dashboarddeployments_jckl_dashboardtemplatesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'jckl_dashboarddeployments_jckl_dashboardtemplates_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'jckl_dashboardtemplates_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'jckl_dashboarddeployments_jckl_dashboardtemplates_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'jckl_dashboarddeployments_idb',
      ),
    ),
  ),
);