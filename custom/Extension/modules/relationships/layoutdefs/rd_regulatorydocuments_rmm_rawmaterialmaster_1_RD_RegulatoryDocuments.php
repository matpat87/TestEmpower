<?php
 // created: 2023-01-27 08:37:36
$layout_defs["RD_RegulatoryDocuments"]["subpanel_setup"]['rd_regulatorydocuments_rmm_rawmaterialmaster_1'] = array (
  'order' => 100,
  'module' => 'RMM_RawMaterialMaster',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RD_REGULATORYDOCUMENTS_RMM_RAWMATERIALMASTER_1_FROM_RMM_RAWMATERIALMASTER_TITLE',
  'get_subpanel_data' => 'rd_regulatorydocuments_rmm_rawmaterialmaster_1',
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