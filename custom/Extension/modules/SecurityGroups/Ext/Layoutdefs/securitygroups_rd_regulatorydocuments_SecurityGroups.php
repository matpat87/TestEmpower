<?php
 // created: 2020-12-04 15:53:46
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_rd_regulatorydocuments'] = array (
  'order' => 100,
  'module' => 'RD_RegulatoryDocuments',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_RD_REGULATORYDOCUMENTS_TITLE',
  'get_subpanel_data' => 'securitygroups_rd_regulatorydocuments',
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
