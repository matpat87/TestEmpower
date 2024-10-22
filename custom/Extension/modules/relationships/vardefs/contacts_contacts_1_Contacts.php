<?php
// created: 2022-09-16 08:31:16
$dictionary["Contact"]["fields"]["contacts_contacts_1"] = array (
  'name' => 'contacts_contacts_1',
  'type' => 'link',
  'relationship' => 'contacts_contacts_1',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'vname' => 'LBL_CONTACTS_CONTACTS_1_FROM_CONTACTS_L_TITLE',
  'id_name' => 'contacts_contacts_1contacts_ida',
);
$dictionary["Contact"]["fields"]["contacts_contacts_1_name"] = array (
  'name' => 'contacts_contacts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTACTS_CONTACTS_1_FROM_CONTACTS_L_TITLE',
  'save' => true,
  'id_name' => 'contacts_contacts_1contacts_ida',
  'link' => 'contacts_contacts_1',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Contact"]["fields"]["contacts_contacts_1contacts_ida"] = array (
  'name' => 'contacts_contacts_1contacts_ida',
  'type' => 'link',
  'relationship' => 'contacts_contacts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CONTACTS_CONTACTS_1_FROM_CONTACTS_R_TITLE',
);
