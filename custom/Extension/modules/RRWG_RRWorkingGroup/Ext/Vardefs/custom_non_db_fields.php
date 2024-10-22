<?php 

$dictionary['RRWG_RRWorkingGroup']['fields']['full_name_non_db']= array(
    'name' => 'full_name_non_db',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['RRWG_RRWorkingGroup']['fields']['first_name_non_db']= array(
    'name' => 'first_name_non_db',
    'vname' => 'LBL_FIRST_NAME_NON_DB',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['RRWG_RRWorkingGroup']['fields']['last_name_non_db']= array(
    'name' => 'last_name_non_db',
    'vname' => 'LBL_LAST_NAME_NON_DB',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['RRWG_RRWorkingGroup']['fields']['phone_work_non_db']= array(
    'name' => 'phone_work_non_db',
    'vname' => 'LBL_WORK_PHONE_NON_DB',
    'type' => 'phone',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['RRWG_RRWorkingGroup']['fields']['phone_mobile_non_db']=  array (
    'name' => 'phone_mobile_non_db',
    'vname' => 'LBL_MOBILE_PHONE_NON_DB',
    'type' => 'phone',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['RRWG_RRWorkingGroup']['fields']['company_non_db']=  array (
    'name' => 'company_non_db',
    'vname' => 'LBL_COMPANY_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['RRWG_RRWorkingGroup']['fields']['email_address_non_db']=  array (
    'name' => 'email_address_non_db',
    'vname' => 'LBL_EMAIL_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);
$dictionary['RRWG_RRWorkingGroup']['fields']['rr_number_non_db']=  array (
    'name' => 'rr_number_non_db',
    'vname' => 'LBL_RR_NUMBER_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);
$dictionary['RRWG_RRWorkingGroup']['fields']['regulatory_request_status_non_db']=  array (
    'name' => 'regulatory_request_status_non_db',
    'vname' => 'LBL_REGULATORY_REQUEST_STATUS_NON_DB',
    'type' => 'enum',
    'options' => 'reg_req_statuses',
    'len' => '50',
    'massupdate' => '0',
    'source' => 'non-db',
);