<?php
 // created: 2021-08-15 14:31:40
$layout_defs["CHL_Challenges"]["subpanel_setup"]['chl_challenges_meetings_1'] = array (
  'order' => 100,
  'module' => 'Meetings',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CHL_CHALLENGES_MEETINGS_1_FROM_MEETINGS_TITLE',
  'get_subpanel_data' => 'chl_challenges_meetings_1',
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
