<?php 

$dictionary['TRWG_TRWorkingGroup']['fields']['full_name_non_db']= array(
    'name' => 'full_name_non_db',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['TRWG_TRWorkingGroup']['fields']['first_name_non_db']= array(
    'name' => 'first_name_non_db',
    'vname' => 'LBL_FIRST_NAME_NON_DB',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['TRWG_TRWorkingGroup']['fields']['last_name_non_db']= array(
    'name' => 'last_name_non_db',
    'vname' => 'LBL_LAST_NAME_NON_DB',
    'type' => 'name',
    'len' => '30',
    'source' => 'non-db',
);

$dictionary['TRWG_TRWorkingGroup']['fields']['phone_work_non_db']= array(
    'name' => 'phone_work_non_db',
    'vname' => 'LBL_WORK_PHONE_NON_DB',
    'type' => 'phone',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['TRWG_TRWorkingGroup']['fields']['phone_mobile_non_db']=  array (
    'name' => 'phone_mobile_non_db',
    'vname' => 'LBL_MOBILE_PHONE_NON_DB',
    'type' => 'phone',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['TRWG_TRWorkingGroup']['fields']['company_non_db']=  array (
    'name' => 'company_non_db',
    'vname' => 'LBL_COMPANY_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);

$dictionary['TRWG_TRWorkingGroup']['fields']['email_address_non_db']=  array (
    'name' => 'email_address_non_db',
    'vname' => 'LBL_EMAIL_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);
$dictionary['TRWG_TRWorkingGroup']['fields']['tr_number_c_nondb']=  array (
    'name' => 'tr_number_c_nondb',
    'vname' => 'LBL_TR_NUMBER_NON_DB',
    'type' => 'varchar',
    'len' => '50',
    'source' => 'non-db',
);
$dictionary['TRWG_TRWorkingGroup']['fields']['technical_request_sales_stage_non_db']=  array (
    'name' => 'technical_request_sales_stage_non_db',
    'vname' => 'LBL_TECHNICAL_REQUEST_SALES_STAGE_NON_DB',
    'type' => 'enum',
    'options' => 'approval_stage_list',
    'len' => '50',
    'massupdate' => '0',
    'source' => 'non-db',
);