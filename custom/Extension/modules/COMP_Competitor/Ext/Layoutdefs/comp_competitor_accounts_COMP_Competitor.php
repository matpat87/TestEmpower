<?php
 // created: 2021-11-19 10:00:49
$layout_defs["COMP_Competitor"]["subpanel_setup"]['comp_competitor_accounts'] = array (
  'order' => 100,
  'module' => 'Accounts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_COMP_COMPETITOR_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'get_subpanel_data' => 'comp_competitor_accounts',
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
