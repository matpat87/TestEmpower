<?php
 // created: 2020-11-03 07:45:29
$layout_defs["SO_SavingOpportunities"]["subpanel_setup"]['so_savingopportunities_vc_vendorcontacts_1'] = array (
  'order' => 100,
  'module' => 'VC_VendorContacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SO_SAVINGOPPORTUNITIES_VC_VENDORCONTACTS_1_FROM_VC_VENDORCONTACTS_TITLE',
  'get_subpanel_data' => 'so_savingopportunities_vc_vendorcontacts_1',
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
