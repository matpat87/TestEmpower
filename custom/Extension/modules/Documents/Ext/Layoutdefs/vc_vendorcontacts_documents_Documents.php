<?php
 // created: 2020-10-19 11:04:27
$layout_defs["Documents"]["subpanel_setup"]['vc_vendorcontacts_documents'] = array (
  'order' => 100,
  'module' => 'VC_VendorContacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VC_VENDORCONTACTS_DOCUMENTS_FROM_VC_VENDORCONTACTS_TITLE',
  'get_subpanel_data' => 'vc_vendorcontacts_documents',
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