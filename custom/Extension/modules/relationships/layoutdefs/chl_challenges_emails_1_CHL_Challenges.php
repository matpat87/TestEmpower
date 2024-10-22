<?php
 // created: 2021-08-15 14:29:05
$layout_defs["CHL_Challenges"]["subpanel_setup"]['chl_challenges_emails_1'] = array (
  'order' => 100,
  'module' => 'Emails',
  'subpanel_name' => 'ForQueues',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CHL_CHALLENGES_EMAILS_1_FROM_EMAILS_TITLE',
  'get_subpanel_data' => 'chl_challenges_emails_1',
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
