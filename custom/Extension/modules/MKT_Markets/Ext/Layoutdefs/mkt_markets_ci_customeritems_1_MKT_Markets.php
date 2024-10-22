<?php
 // created: 2020-12-14 08:40:12
$layout_defs["MKT_Markets"]["subpanel_setup"]['mkt_markets_ci_customeritems_1'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_MKT_MARKETS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'mkt_markets_ci_customeritems_1',
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
