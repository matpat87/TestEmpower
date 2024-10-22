<?php
 // created: 2021-05-04 10:41:29
$layout_defs["MKT_NewMarkets"]["subpanel_setup"]['mkt_newmarkets_ci_customeritems_1'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'accounts',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_MKT_NEWMARKETS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'mkt_newmarkets_ci_customeritems_1',
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
