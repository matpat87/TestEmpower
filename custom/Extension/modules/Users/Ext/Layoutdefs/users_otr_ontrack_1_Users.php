<?php
 // created: 2020-05-03 11:11:35
$layout_defs["Users"]["subpanel_setup"]['users_otr_ontrack_1'] = array (
  'order' => 100,
  'module' => 'OTR_OnTrack',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_USERS_OTR_ONTRACK_1_FROM_OTR_ONTRACK_TITLE',
  'get_subpanel_data' => 'users_otr_ontrack_1',
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
