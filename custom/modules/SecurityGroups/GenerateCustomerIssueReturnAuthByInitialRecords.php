<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=SecurityGroups&action=GenerateCustomerIssueReturnAuthByInitialRecords
generateCustomerIssueReturnAuthByInitialRecords();

/*
 * Function also includes generating Security Group Records for the
 * Customer Issues: Return Authorization By dropdown AND the Department Manager assigned User as per Workflow
 *  */
function generateCustomerIssueReturnAuthByInitialRecords()
{
    global $app_list_strings;

    $siteList = $app_list_strings['site_list'];
    // Note: Executive should remain role dependent on division ChromaCorporate
    // Reason: There are multiple users in a site with the role Executive (Ex. Lambertville)
    $aclRolesForReturnAuth = [
        'Quality Control Manager',
        'Plant Manager',
        'Customer Service Manager',
        'R&D Manager',
        'Shipping Manager',
        'Production Manager',
        'Billing Manager',
        'Purchasing Manager'
    ];

    // Loop $aclRolesForReturnAuth to create security group with tyoe CAPAWorkingGroup
    foreach ($aclRolesForReturnAuth as $aclRole) {

        if (in_array($aclRole, ['Purchasing Manager'])) {

            if (! checkIfRecordExists($aclRole, 'CAPAWorkingGroup')) {
                $aclRoleUser = retrieveSecurityGroupAssignedUser($aclRole); // User Bean

                $secGroupBean = BeanFactory::newBean('SecurityGroups');
                $secGroupBean->name = $aclRole;
                $secGroupBean->type_c = 'CAPAWorkingGroup';
                $secGroupBean->site_c = NULL;
                $secGroupBean->division_c = 'ChromaColor';
                $secGroupBean->noninheritable = 1;
                $secGroupBean->description = 'CAPA Working Group Assignment';
                $secGroupBean->assigned_user_id = $aclRoleUser->id ?? '';
                $secGroupBean->save(false);

                echo "<pre>";
                echo "Created New Record: {$aclRole} - {$siteKey} - CAPAWorkingGroup <br />";
                echo "User ID: {$aclRoleUser->id} - {$aclRoleUser->first_name} {$aclRoleUser->last_name}";
                echo "</pre>";
            }
        } else {
            // loop through $siteList
            foreach ($siteList as $siteKey => $siteValue) {
                if ($siteKey === '') {
                    continue;
                }

                if (! checkIfRecordExists($aclRole, 'CAPAWorkingGroup', $siteKey)) {
                    $aclRoleUser = retrieveUserByRoleSiteDivision($aclRole, $siteKey, 'ChromaColor'); // User Bean

                    $secGroupBean = BeanFactory::newBean('SecurityGroups');
                    $secGroupBean->name = $aclRole;
                    $secGroupBean->type_c = 'CAPAWorkingGroup';
                    $secGroupBean->site_c = $siteKey;
                    $secGroupBean->division_c = 'ChromaColor';
                    $secGroupBean->noninheritable = 1;
                    $secGroupBean->description = 'CAPA Working Group Assignment';
                    $secGroupBean->assigned_user_id = $aclRoleUser->id ?? '';
                    $secGroupBean->save(false);

                    echo "<pre>";
                    echo "Created New Record: {$aclRole} - {$siteKey} - CAPAWorkingGroup <br />";
                    echo "User ID: {$aclRoleUser->id} - {$aclRoleUser->first_name} {$aclRoleUser->last_name}";
                    echo "</pre>";
                }
            }
        }

    }
    // loop $aclRolesForReturnAuth

}

// function that will revert the generateCustomerIssueReturnAuthByInitialRecords()
function removeCustomerIssueReturnAuthByInitialRecords()
{
    global $app_list_strings, $db;

    $idsArray = [];
    $siteList = $app_list_strings['site_list'];
    $aclRolesForReturnAuth = ['Plant Manager', 'Executive'];

    // Loop $aclRolesForReturnAuth to create security group with tyoe CAPAWorkingGroup
    foreach ($aclRolesForReturnAuth as $aclRole) {
        // loop through $siteList
        foreach ($siteList as $siteKey => $siteValue) {
            if ($siteKey === '') {
                continue;
            }

            if (checkIfRecordExists($aclRole, 'CAPAWorkingGroup', $siteKey)) {
                $secGroupBean = BeanFactory::newBean('SecurityGroups');
                $secGroupBean->retrieve_by_string_fields([
                    'name' => $aclRole,
                    'type_c' => 'CAPAWorkingGroup',
                    'site_c' => $siteKey,
                    'division_c' => 'ChromaColor',
                ]);

                array_push($idsArray, $secGroupBean->id);
                echo "<pre>";
                echo "Deleted Record: {$aclRole} - {$siteKey} - CAPAWorkingGroup";
                echo "</pre>";
            }
        }
    }

    // delete using sql query
    $ids = implode("','", $idsArray);
    $query = "DELETE FROM securitygroups WHERE id IN ('{$ids}')";
    $db->query($query);



}

function checkIfRecordExists($name, $type, $site = null, $division = 'ChromaColor')
{
    global $db;

    $siteFilter = ($site)
        ? "AND securitygroups_cstm.site_c = '{$site}'"
        : "";

    $divisionFilter = ($division)
        ? "AND securitygroups_cstm.division_c = '{$division}'"
        : "";

    $query = "SELECT COUNT(securitygroups.id) FROM securitygroups 
        LEFT JOIN securitygroups_cstm
            ON securitygroups.id = securitygroups_cstm.id_c
        WHERE securitygroups.deleted = 0
            AND securitygroups.name = '{$name}'
            AND securitygroups_cstm.type_c = '{$type}'
            {$siteFilter}
            {$divisionFilter}
    ";

    $result = $db->getOne($query);

    return ($result) ? true : false;
}

function retrieveSecurityGroupAssignedUser($name, $site = null, $division = 'ChromaColor')
{
    if ($name == 'Color Match Coordinator') {
        $name = 'Colormatch Coordinator';
    }

    $userBean = retrieveUserByRoleSiteDivision($name, $site, $division);

    if (! $userBean->id) {
        return false;
    }

    return $userBean;
}