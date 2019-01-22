<?php
 // created: 2018-07-24 16:54:06
$layout_defs["Documents"]["subpanel_setup"]['documents_otr_ontrack_1'] = array (
  'order' => 100,
  'module' => 'OTR_OnTrack',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_DOCUMENTS_OTR_ONTRACK_1_FROM_OTR_ONTRACK_TITLE',
  'get_subpanel_data' => 'documents_otr_ontrack_1',
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
