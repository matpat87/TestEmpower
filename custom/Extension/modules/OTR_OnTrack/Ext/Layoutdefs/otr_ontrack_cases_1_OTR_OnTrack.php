<?php
 // created: 2018-08-11 09:35:39
$layout_defs["OTR_OnTrack"]["subpanel_setup"]['otr_ontrack_cases_1'] = array (
  'order' => 100,
  'module' => 'Cases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_OTR_ONTRACK_CASES_1_FROM_CASES_TITLE',
  'get_subpanel_data' => 'otr_ontrack_cases_1',
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
