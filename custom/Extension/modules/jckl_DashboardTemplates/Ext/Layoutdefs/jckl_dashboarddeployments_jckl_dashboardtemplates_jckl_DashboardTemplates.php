<?php
 // created: 2016-09-03 05:37:17
$layout_defs["jckl_DashboardTemplates"]["subpanel_setup"]['jckl_dashboarddeployments_jckl_dashboardtemplates'] = array (
  'order' => 100,
  'module' => 'jckl_DashboardDeployments',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_JCKL_DASHBOARDDEPLOYMENTS_JCKL_DASHBOARDTEMPLATES_FROM_JCKL_DASHBOARDDEPLOYMENTS_TITLE',
  'get_subpanel_data' => 'jckl_dashboarddeployments_jckl_dashboardtemplates',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
