<?php
 // created: 2021-10-28 12:58:50
$layout_defs["Cases"]["subpanel_setup"]['cases_ci_customeritems_1'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CASES_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'cases_ci_customeritems_1',
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
