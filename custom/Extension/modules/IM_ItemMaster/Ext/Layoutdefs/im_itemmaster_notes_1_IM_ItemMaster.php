<?php
 // created: 2019-01-15 14:53:45
$layout_defs["IM_ItemMaster"]["subpanel_setup"]['im_itemmaster_notes_1'] = array (
  'order' => 100,
  'module' => 'Notes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_IM_ITEMMASTER_NOTES_1_FROM_NOTES_TITLE',
  'get_subpanel_data' => 'im_itemmaster_notes_1',
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
