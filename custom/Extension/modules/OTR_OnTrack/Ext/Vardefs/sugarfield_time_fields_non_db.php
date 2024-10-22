<?php

$dictionary['OTR_OnTrack']['fields']['work_performed_non_db']= array(
    'name' => 'work_performed_non_db',
    'vname' => 'LBL_WORK_PERFORMED_NON_DB',
    'type' => 'varchar',
    'len' => '255',
    'source' => 'non-db',
);

$dictionary['OTR_OnTrack']['fields']['work_description_non_db']= array(
    'name' => 'work_description_non_db',
    'vname' => 'LBL_WORK_DESCRIPTION_NON_DB',
    'type' => 'text',
    'rows' => 6,
    'cols' => 80,
    'source' => 'non-db'
);
$dictionary['OTR_OnTrack']['fields']['time_non_db']= array(
    'name' => 'time_non_db',
    'vname' => 'LBL_TIME_NON_DB',
    'type' => 'float',
    'inline_edit' => true,
    'len' => '5',
    'precision' => '2',
    'source' => 'non-db'
);

$dictionary['OTR_OnTrack']['fields']['date_worked_non_db']= array(
    'name' => 'date_worked_non_db',
    'vname' => 'LBL_DATE_WORKED_NON_DB',
    'type' => 'date',
    'no_default' => false,
    'inline_edit' => true,
    'len' => '5',
    'size' => '20',
    'precision' => '2',
    'source' => 'non-db',
    'display_default' => 'now',
);
$dictionary['OTR_OnTrack']['fields']['add_time_non_db']= array(
    'name' => 'add_time_non_db',
    'vname' => 'LBL_ADD_TIME_NON_DB',
    'type' => 'bool',
    'len' => '255',
    'size' => '20',
    'no_default' => false,
    'inline_edit' => true,
    'source' => 'non-db',
);