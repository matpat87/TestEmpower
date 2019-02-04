<?php
 // created: 2019-02-04 16:24:24
$layout_defs["CI_CustomerItems"]["subpanel_setup"]['ci_customeritems_notes'] = array (
  'order' => 100,
  'module' => 'Notes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CI_CUSTOMERITEMS_NOTES_FROM_NOTES_TITLE',
  'get_subpanel_data' => 'ci_customeritems_notes',
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
