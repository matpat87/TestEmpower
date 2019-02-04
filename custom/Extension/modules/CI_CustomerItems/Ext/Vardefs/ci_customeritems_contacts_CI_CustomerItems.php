<?php
// created: 2019-02-04 16:24:24
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_contacts"] = array (
  'name' => 'ci_customeritems_contacts',
  'type' => 'link',
  'relationship' => 'ci_customeritems_contacts',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CONTACTS_FROM_CONTACTS_TITLE',
  'id_name' => 'ci_customeritems_contactscontacts_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_contacts_name"] = array (
  'name' => 'ci_customeritems_contacts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CONTACTS_FROM_CONTACTS_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_contactscontacts_ida',
  'link' => 'ci_customeritems_contacts',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_contactscontacts_ida"] = array (
  'name' => 'ci_customeritems_contactscontacts_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_contacts',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CONTACTS_FROM_CI_CUSTOMERITEMS_TITLE',
);
