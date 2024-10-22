<?php
 // created: 2020-08-24 07:48:03
$layout_defs["Documents"]["subpanel_setup"]['projecttask_documents_1'] = array (
  'order' => 100,
  'module' => 'ProjectTask',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROJECTTASK_DOCUMENTS_1_FROM_PROJECTTASK_TITLE',
  'get_subpanel_data' => 'projecttask_documents_1',
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
