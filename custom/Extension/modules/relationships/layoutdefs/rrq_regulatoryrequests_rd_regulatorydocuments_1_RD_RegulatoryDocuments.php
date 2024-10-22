<?php
 // created: 2023-06-12 07:56:57
$layout_defs["RD_RegulatoryDocuments"]["subpanel_setup"]['rrq_regulatoryrequests_rd_regulatorydocuments_1'] = array (
  'order' => 100,
  'module' => 'RRQ_RegulatoryRequests',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RRQ_REGULATORYREQUESTS_RD_REGULATORYDOCUMENTS_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
  'get_subpanel_data' => 'rrq_regulatoryrequests_rd_regulatorydocuments_1',
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
