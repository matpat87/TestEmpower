<?php
 // created: 2023-07-05 08:09:08
$layout_defs["RRQ_RegulatoryRequests"]["subpanel_setup"]['rrq_regulatoryrequests_ci_customeritems_2'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'accounts',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RRQ_REGULATORYREQUESTS_CI_CUSTOMERITEMS_2_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'rrq_regulatoryrequests_ci_customeritems_2',
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
    2 => 
    array (
      'widget_class' => 'SubPanelCustomerProductsSelectButton',
    ),
  ),
);
