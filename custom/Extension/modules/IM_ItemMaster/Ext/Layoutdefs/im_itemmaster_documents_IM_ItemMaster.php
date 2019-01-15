<?php
 // created: 2019-01-14 16:45:34
$layout_defs["IM_ItemMaster"]["subpanel_setup"]['im_itemmaster_documents'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_IM_ITEMMASTER_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'im_itemmaster_documents',
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
