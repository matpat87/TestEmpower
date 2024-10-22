<?php
 // created: 2021-01-27 08:04:16
$layout_defs["CI_CustomerItems"]["subpanel_setup"]['ci_customeritems_cases_1'] = array (
  'order' => 100,
  'module' => 'Cases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CI_CUSTOMERITEMS_CASES_1_FROM_CASES_TITLE',
  'get_subpanel_data' => 'ci_customeritems_cases_1',
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

/**
 * Note: Relationship is used as a field in the Customer Issues form (One CI Many Customer Issues)
 * Subpanel should be hidden
 * Customer Issue Form uses Product # field with value of ci_customeritems_cases_1ci_customeritems_ida
 *  */
unset($layout_defs["CI_CustomerItems"]["subpanel_setup"]['ci_customeritems_cases_1']);

