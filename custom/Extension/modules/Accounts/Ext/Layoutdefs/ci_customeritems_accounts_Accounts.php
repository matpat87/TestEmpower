<?php
 // created: 2019-02-04 16:24:24
$layout_defs["Accounts"]["subpanel_setup"]['ci_customeritems_accounts'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'accounts',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'ci_customeritems_accounts',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
  ),
);
