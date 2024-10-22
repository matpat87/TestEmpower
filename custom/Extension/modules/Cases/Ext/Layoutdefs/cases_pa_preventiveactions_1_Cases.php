<?php
 // created: 2021-04-08 09:34:48
$layout_defs["Cases"]["subpanel_setup"]['cases_pa_preventiveactions_1'] = array (
  'order' => 2,
  'module' => 'PA_PreventiveActions',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CASES_PA_PREVENTIVEACTIONS_1_FROM_PA_PREVENTIVEACTIONS_TITLE',
  'get_subpanel_data' => 'cases_pa_preventiveactions_1',
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
