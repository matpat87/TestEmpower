<?php
 // created: 2019-02-04 16:24:24
$layout_defs["CI_CustomerItems"]["subpanel_setup"]['ci_customeritems_documents'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CI_CUSTOMERITEMS_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'ci_customeritems_documents',
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