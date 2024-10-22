<?php
 // created: 2020-12-04 15:53:46
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_vi_vendorissues'] = array (
  'order' => 100,
  'module' => 'VI_VendorIssues',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_VI_VENDORISSUES_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'securitygroups_vi_vendorissues',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
