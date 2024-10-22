<?php
// created: 2022-09-17 07:22:39
$dictionary["RRQ_RegulatoryRequests"]["fields"]["contacts_rrq_regulatoryrequests_1"] = array (
  'name' => 'contacts_rrq_regulatoryrequests_1',
  'type' => 'link',
  'relationship' => 'contacts_rrq_regulatoryrequests_1',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'vname' => 'LBL_CONTACTS_RRQ_REGULATORYREQUESTS_1_FROM_CONTACTS_TITLE',
  'id_name' => 'contacts_rrq_regulatoryrequests_1contacts_ida',
);
$dictionary["RRQ_RegulatoryRequests"]["fields"]["contacts_rrq_regulatoryrequests_1_name"] = array (
  'name' => 'contacts_rrq_regulatoryrequests_1_name',
  'required' => true,
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTACTS_RRQ_REGULATORYREQUESTS_1_FROM_CONTACTS_TITLE',
  'save' => true,
  'id_name' => 'contacts_rrq_regulatoryrequests_1contacts_ida',
  'link' => 'contacts_rrq_regulatoryrequests_1',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["RRQ_RegulatoryRequests"]["fields"]["contacts_rrq_regulatoryrequests_1contacts_ida"] = array (
  'name' => 'contacts_rrq_regulatoryrequests_1contacts_ida',
  'type' => 'link',
  'relationship' => 'contacts_rrq_regulatoryrequests_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CONTACTS_RRQ_REGULATORYREQUESTS_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
);
