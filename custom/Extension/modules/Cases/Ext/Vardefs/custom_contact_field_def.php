<?php

$dictionary['Case']['fields']['contact_created_by']= array (
    'name' => 'contact_created_by',
    'type' => 'link',
    'relationship' => 'cases_created_contact',
    'module' => 'Contacts',
    'bean_name' => 'Contact',
    'link_type' => 'one',
    'source' => 'non-db',
    'vname' => 'LBL_CONTACT_CREATED_BY',
    'side' => 'left',
    'id_name' => 'contact_created_by_id'
);

$dictionary['Case']['fields']['contact_created_by_name'] = array (
    'name' => 'contact_created_by_name',
    'required' => true,
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_CONTACT_CREATED_BY_NAME',
    'save' => true,
    'id_name' => 'contact_created_by_id',
    'link' => 'cases_created_contact',
    'table' => 'Contacts',
    'module' => 'Contacts',
    'audited' => true,
);

$dictionary['Case']['fields']['contact_created_by_id'] = array (
    'name' => 'contact_created_by_id',
    'type' => 'id',
    'reportable' => false,
    'vname' => 'LBL_CONTACT_CREATED_BY_ID',
);


?>