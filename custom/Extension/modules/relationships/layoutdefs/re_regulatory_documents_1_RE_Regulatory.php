<?php
 // created: 2018-06-23 09:09:53
$layout_defs["RE_Regulatory"]["subpanel_setup"]['re_regulatory_documents_1'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RE_REGULATORY_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 're_regulatory_documents_1',
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
