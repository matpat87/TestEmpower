<?php
 // created: 2020-11-26 08:36:39
$layout_defs["Documents"]["subpanel_setup"]['tr_technicalrequests_documents'] = array (
  'order' => 100,
  'module' => 'TR_TechnicalRequests',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TR_TECHNICALREQUESTS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'tr_technicalrequests_documents',
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