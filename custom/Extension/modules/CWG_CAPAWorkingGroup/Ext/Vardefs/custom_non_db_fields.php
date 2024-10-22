<?php 

$dictionary['CWG_CAPAWorkingGroup']['fields']['full_name_non_db']= array(
    'name' => 'full_name_non_db',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['CWG_CAPAWorkingGroup']['fields']['parent_name_non_db']= array(
    'name' => 'parent_name_non_db',
    'vname' => 'LBL_FLEX_RELATE',
    'type' => 'varchar',
    'len' => '255',
    'source' => 'non-db',
);
$dictionary['CWG_CAPAWorkingGroup']['fields']['parent_type_non_db']= array(
    'name' => 'parent_type_non_db',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'varchar',
    'len' => '255',
    'source' => 'non-db',
);

$dictionary['CWG_CAPAWorkingGroup']['fields']['first_name_non_db']= array(
    'name' => 'first_name_non_db',
    'vname' => 'LBL_FIRST_NAME_NON_DB',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['CWG_CAPAWorkingGroup']['fields']['last_name_non_db']= array(
    'name' => 'last_name_non_db',
    'vname' => 'LBL_LAST_NAME_NON_DB',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['CWG_CAPAWorkingGroup']['fields']['phone_work_non_db']= array(
    'name' => 'phone_work_non_db',
    'vname' => 'LBL_WORK_PHONE_NON_DB',
    'type' => 'phone',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['CWG_CAPAWorkingGroup']['fields']['phone_mobile_non_db']=  array (
    'name' => 'phone_mobile_non_db',
    'vname' => 'LBL_MOBILE_PHONE_NON_DB',
    'type' => 'phone',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['CWG_CAPAWorkingGroup']['fields']['company_non_db']=  array (
    'name' => 'company_non_db',
    'vname' => 'LBL_COMPANY_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);
$dictionary['CWG_CAPAWorkingGroup']['fields']['email_address_non_db']=  array (
    'name' => 'email_address_non_db',
    'vname' => 'LBL_EMAIL_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['CWG_CAPAWorkingGroup']['fields']['cases_status_non_db']=  array (
    'name' => 'cases_status_non_db',
    'vname' => 'LBL_CASES_STATUS_NON_DB',
    'type' => 'enum',
    'options' => 'status_list',
    'len' => '50',
    'massupdate' => '0',
    'source' => 'non-db',
);
