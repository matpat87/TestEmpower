<?php
 // created: 2021-11-23 02:08:20
$layout_defs["Accounts"]["subpanel_setup"]['accounts_comp_competitor_1'] = array (
  'order' => 100,
  'module' => 'COMP_Competitor',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_COMP_COMPETITOR_1_FROM_COMP_COMPETITOR_TITLE',
  'get_subpanel_data' => 'accounts_comp_competitor_1',
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
