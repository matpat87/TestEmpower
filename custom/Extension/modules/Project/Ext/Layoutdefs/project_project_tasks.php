<?php

$layout_defs["Project"]["subpanel_setup"]['project_project_task'] = array (
  'order' => 100,
  'module' => 'ProjectTask',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROJECT_TASK_SUBPANEL_TITLE',
  'get_subpanel_data' => 'project_task',
  'top_buttons' => array(
    array(
        'widget_class' => 'SubPanelProjectTaskCreateButton',
    ),
  ),
);
