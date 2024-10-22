<?php

$job_strings[] = 'assignDivisionLevelSecurityGroupScheduler';

function assignDivisionLevelSecurityGroupScheduler()
{
    global $db, $app_list_strings;

    $GLOBALS['log']->fatal("Assign Division Level Security Group Scheduler - START");

    $acceptedModules = [
        'Leads', 'Accounts', 'Contacts', 'Opportunities',
        'TR_TechnicalRequests', 'DSBTN_Distribution', 'AOS_Products', 'CI_CustomerItems',
        'Cases', 'Documents', 'EHS_EHS', 'RE_Regulatory', 'Campaigns',
        'Calls', 'Meetings',' Tasks', 'Notes', 'Emails', 'CHL_Challenges',
        'TRWG_TRWorkingGroup', 'TRI_TechnicalRequestItems', 'RRQ_RegulatoryRequests', 'RRWG_RRWorkingGroup'
    ];

    foreach ($acceptedModules as $module) {

        $tableName = strtolower($module);

        if (! checkIfTableExists($tableName)) {
            continue;
        }

        $cstmTableExists = checkIfTableExists("{$tableName}_cstm") ? true : false;

        $GLOBALS['log']->fatal("{$module} - START");
        
        $moduleRecords = retrieveModuleRecords($tableName, $cstmTableExists);

        if (! $moduleRecords) {
            continue;
        }

        while( $row = $db->fetchByAssoc($moduleRecords)) {
            // If division or division_c field has a value, insert division level security group, else assign division of creator and insert division level security group
            if (isset($row['division']) && ! empty($row['division']) && array_key_exists($row['division'], $app_list_strings['user_division_list']) || 
                isset($row['division_c']) && ! empty($row['division_c']) && array_key_exists($row['division_c'], $app_list_strings['user_division_list'])
            ) {
                $divisionFieldValue = $row['division'] ?? $row['division_c'];
                assignDivisionLevelSecurityGroup($divisionFieldValue, $row['id'], $module);
            } else {
                $user = BeanFactory::getBean('Users', $row['created_by']);

                // If record creator does not exist or has no division, skip process
                if (! $user || ! $user->division_c) continue;

                if (array_key_exists('division', $row) && empty($row['division'])) {
                    $divisionFieldColumn = 'division';
                }
            
                if (array_key_exists('division_c', $row) && empty($row['division_c'])) {
                    $divisionFieldColumn = 'division_c';
                }

                $divisionFieldValue = $user->division_c;
                
                if ($divisionFieldColumn && $divisionFieldValue) {
                    updateRecordDivision($tableName, $cstmTableExists, $row['id'], $divisionFieldColumn, $divisionFieldValue);
                    assignDivisionLevelSecurityGroup($divisionFieldValue, $row['id'], $module);

                    $GLOBALS['log']->fatal("{$module} - [{$row['id']}] New Division: {$app_list_strings['user_division_list'][$divisionFieldValue]}");
                }
            }
        }

        
        $GLOBALS['log']->fatal("{$module} - END");
    }

    $GLOBALS['log']->fatal("Assign Division Level Security Group Scheduler - END");

    return true;
}

function checkIfTableExists($tableName)
{
    global $sugar_config, $db;

    $dbName = $sugar_config['dbconfig']['db_name'];

    $query = "SELECT count(*) FROM information_schema.tables WHERE table_schema = '{$dbName}' AND table_name = '{$tableName}' LIMIT 1";
    $result = $db->getOne($query);
    
    return ($result) ? true : false;
}

function retrieveModuleRecords($tableName, $cstmTableExists)
{
    global $db;

    if ($cstmTableExists) {
        $joinQuery = " INNER JOIN {$tableName}_cstm ON {$tableName}.id = {$tableName}_cstm.id_c ";
    }

    $query = "SELECT * FROM {$tableName} {$joinQuery} WHERE deleted = 0";
    $result = $db->query($query);

    return $result;
}

function updateRecordDivision($tableName, $cstmTableExists, $recordId, $divisionFieldColumn, $divisionFieldValue)
{
    global $db;

    $query = " UPDATE {$tableName} ";

    if ($cstmTableExists) {
        $query .= " INNER JOIN {$tableName}_cstm ON {$tableName}.id = {$tableName}_cstm.id_c ";
    }

    $query .= " SET {$divisionFieldColumn} = '{$divisionFieldValue}' WHERE id = '{$recordId}' ";

    $GLOBALS['log']->fatal("UPDATE QUERY: {$query}");
    $db->query($query);

    return true;
}

function assignDivisionLevelSecurityGroup($division, $recordId, $moduleName)
{
    global $app_list_strings;

    $divisionLabel = $app_list_strings['user_division_list'][$division];
    $eventLogId = create_guid();
    
    $securitygroupDivisionBean = BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
        array(
            "division_c" => $division,
            "type_c" => "Division Access",
            "name" => "Level II - {$divisionLabel} Management"
        ), false, true
    );

    if ($securitygroupDivisionBean) {
        if (! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($securitygroupDivisionBean->id, $recordId, $moduleName)) {
            $GLOBALS['log']->fatal("{$moduleName} - [{$recordId}] New Division Level Security Group: Level II - {$divisionLabel} Management");
        }
        
        SecurityGroupHelper::insertOrDeleteSecurityGroupRecord('insert', $securitygroupDivisionBean->id, $recordId, $moduleName, $eventLogId);
    };
}