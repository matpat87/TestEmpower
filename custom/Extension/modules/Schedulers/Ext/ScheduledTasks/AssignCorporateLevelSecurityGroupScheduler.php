<?php

$job_strings[] = 'assignCorporateLevelSecurityGroupScheduler';

function assignCorporateLevelSecurityGroupScheduler()
{
    global $db, $moduleList, $beanList;

    $GLOBALS['log']->fatal("Assign Corporate Level Security Group Scheduler - START");
    
    $filteredModuleList = array_intersect($moduleList,array_keys($GLOBALS['beanList']));
    $corporateSecurityGroupBean = BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
        array(
            "division_c" => "ChromaCorporate",
            "type_c" => "Division Access",
            "name" => "Level III - Chroma Corporate Access"
        ), false, true
    );

    if ($corporateSecurityGroupBean && $corporateSecurityGroupBean->id) {
        foreach ($filteredModuleList as $module) {
            if (
                strpos(strtolower($module), 'log') !== false || 
                strpos(strtolower($module), 'group') !== false || 
                strpos(strtolower($module), 'jjwg') !== false
            ) {
                continue;
            }

            $moduleData = retrieveModuleData($module);
    
            if (! $moduleData) {
                continue;
            }
            
            $GLOBALS['log']->fatal("{$module} - START");

            while ($row = $db->fetchByAssoc($moduleData)) {
                assignCorporateLevelSecurityGroup($corporateSecurityGroupBean->id, $row['id'], $module);
            }
    
            $GLOBALS['log']->fatal("{$module} - END");
        }
    }

    $GLOBALS['log']->fatal("Assign Corporate Level Security Group Scheduler - END");

    return true;
}

function assignCorporateLevelSecurityGroup($securityGroupBeanId, $recordId, $moduleName) {
    $eventLogId = create_guid();
    
    if (! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($securityGroupBeanId, $recordId, $moduleName)) {
        SecurityGroupHelper::insertOrDeleteSecurityGroupRecord('insert', $securityGroupBeanId, $recordId, $moduleName, $eventLogId);
        $GLOBALS['log']->fatal("{$moduleName} - [{$recordId}] New Corporate Level Security Group: Level III - Chroma Corporate Access");
    }
}

function retrieveModuleData($moduleName)
{
    global $db;

    // Add Underscore for every occurence of capital letters (Ex. EmailTemplates to Email_Templates)
    if (in_array($moduleName, ['EmailTemplates', 'ProspectLists', 'ProjectTask'])) {
        $moduleName = preg_replace("/(?<=[a-zA-Z])(?=[A-Z])/", "_", $moduleName);
    }
    
    // Append "s" on Module Name as there are instances where Module name is Time but table name is times
    if (in_array($moduleName, ['Time'])) {
        $moduleName .= "s";
    }
    
    $tableName = strtolower($moduleName);
    $query = "SELECT id FROM {$tableName} WHERE deleted = 0";
    $result = $db->query($query);

    return $result;
    
}