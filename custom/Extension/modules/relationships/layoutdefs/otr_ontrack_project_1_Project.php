<?php
 // created: 2018-08-11 09:36:18
$layout_defs["Project"]["subpanel_setup"]['otr_ontrack_project_1'] = array (
  'order' => 100,
  'module' => 'OTR_OnTrack',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_OTR_ONTRACK_PROJECT_1_FROM_OTR_ONTRACK_TITLE',
  'get_subpanel_data' => 'otr_ontrack_project_1',
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
