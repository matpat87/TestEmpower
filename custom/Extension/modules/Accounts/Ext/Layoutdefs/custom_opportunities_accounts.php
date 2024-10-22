<?php
 // created: 2020-07-21 16:20:00
$layout_defs["Accounts"]["subpanel_setup"]['opportunities'] = array (
  'order' => 100,
  'module' => 'Opportunities',
  'subpanel_name' => 'Account_subpanel_opportunities',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_OPPORTUNITIES_ACCOUNTS_TITLE',
  'get_subpanel_data' => 'opportunities',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelOpportunityCreateButton',
    ),
  ),
);
