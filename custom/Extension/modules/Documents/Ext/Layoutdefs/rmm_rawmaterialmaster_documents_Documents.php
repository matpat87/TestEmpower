<?php
 // created: 2020-11-10 09:32:09
$layout_defs["Documents"]["subpanel_setup"]['rmm_rawmaterialmaster_documents'] = array (
  'order' => 100,
  'module' => 'RMM_RawMaterialMaster',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RMM_RAWMATERIALMASTER_DOCUMENTS_FROM_RMM_RAWMATERIALMASTER_TITLE',
  'get_subpanel_data' => 'rmm_rawmaterialmaster_documents',
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
