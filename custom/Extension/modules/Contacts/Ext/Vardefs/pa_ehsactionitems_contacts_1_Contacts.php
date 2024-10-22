<?php
// created: 2021-06-30 13:55:22
$dictionary["Contact"]["fields"]["pa_ehsactionitems_contacts_1"] = array (
  'name' => 'pa_ehsactionitems_contacts_1',
  'type' => 'link',
  'relationship' => 'pa_ehsactionitems_contacts_1',
  'source' => 'non-db',
  'module' => 'PA_EHSActionItems',
  'bean_name' => 'PA_EHSActionItems',
  'vname' => 'LBL_PA_EHSACTIONITEMS_CONTACTS_1_FROM_PA_EHSACTIONITEMS_TITLE',
  'id_name' => 'pa_ehsactionitems_contacts_1pa_ehsactionitems_ida',
);
$dictionary["Contact"]["fields"]["pa_ehsactionitems_contacts_1_name"] = array (
  'name' => 'pa_ehsactionitems_contacts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PA_EHSACTIONITEMS_CONTACTS_1_FROM_PA_EHSACTIONITEMS_TITLE',
  'save' => true,
  'id_name' => 'pa_ehsactionitems_contacts_1pa_ehsactionitems_ida',
  'link' => 'pa_ehsactionitems_contacts_1',
  'table' => 'pa_ehsactionitems',
  'module' => 'PA_EHSActionItems',
  'rname' => 'name',
);
$dictionary["Contact"]["fields"]["pa_ehsactionitems_contacts_1pa_ehsactionitems_ida"] = array (
  'name' => 'pa_ehsactionitems_contacts_1pa_ehsactionitems_ida',
  'type' => 'link',
  'relationship' => 'pa_ehsactionitems_contacts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_PA_EHSACTIONITEMS_CONTACTS_1_FROM_CONTACTS_TITLE',
);
