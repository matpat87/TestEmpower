<?php
 // created: 2018-07-09 16:49:38
$layout_defs["COMP_Competition"]["subpanel_setup"]['accounts_comp_competition_1'] = array (
  'order' => 100,
  'module' => 'Accounts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_COMP_COMPETITION_1_FROM_ACCOUNTS_TITLE',
  'get_subpanel_data' => 'accounts_comp_competition_1',
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