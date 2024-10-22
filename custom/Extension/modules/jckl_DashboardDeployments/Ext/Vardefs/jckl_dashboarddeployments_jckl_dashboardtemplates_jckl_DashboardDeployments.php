<?php
// created: 2016-09-03 05:37:17
$dictionary["jckl_DashboardDeployments"]["fields"]["jckl_dashboarddeployments_jckl_dashboardtemplates"] = array (
  'name' => 'jckl_dashboarddeployments_jckl_dashboardtemplates',
  'type' => 'link',
  'relationship' => 'jckl_dashboarddeployments_jckl_dashboardtemplates',
  'source' => 'non-db',
  'module' => 'jckl_DashboardTemplates',
  'bean_name' => false,
  'vname' => 'LBL_JCKL_DASHBOARDDEPLOYMENTS_JCKL_DASHBOARDTEMPLATES_FROM_JCKL_DASHBOARDTEMPLATES_TITLE',
  'id_name' => 'jckl_dashboardtemplates_ida',
);
$dictionary["jckl_DashboardDeployments"]["fields"]["jckl_dashboarddeployments_jckl_dashboardtemplates_name"] = array (
  'name' => 'jckl_dashboarddeployments_jckl_dashboardtemplates_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_JCKL_DASHBOARDDEPLOYMENTS_JCKL_DASHBOARDTEMPLATES_FROM_JCKL_DASHBOARDTEMPLATES_TITLE',
  'save' => true,
  'id_name' => 'jckl_dashboardtemplates_ida',
  'link' => 'jckl_dashboarddeployments_jckl_dashboardtemplates',
  'table' => 'jckl_dashboardtemplates',
  'module' => 'jckl_DashboardTemplates',
  'rname' => 'name',
);
$dictionary["jckl_DashboardDeployments"]["fields"]["jckl_dashboardtemplates_ida"] = array (
  'name' => 'jckl_dashboardtemplates_ida',
  'type' => 'link',
  'relationship' => 'jckl_dashboarddeployments_jckl_dashboardtemplates',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_JCKL_DASHBOARDDEPLOYMENTS_JCKL_DASHBOARDTEMPLATES_FROM_JCKL_DASHBOARDDEPLOYMENTS_TITLE',
);
