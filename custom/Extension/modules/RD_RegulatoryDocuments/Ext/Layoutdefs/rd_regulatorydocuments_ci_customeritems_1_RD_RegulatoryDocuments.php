<?php
 // created: 2023-01-27 10:41:52
$layout_defs["RD_RegulatoryDocuments"]["subpanel_setup"]['rd_regulatorydocuments_ci_customeritems_1'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'accounts',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RD_REGULATORYDOCUMENTS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'rd_regulatorydocuments_ci_customeritems_1',
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
