<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=SecurityGroups&action=GenerateWorkGroupInitialRecords
generateWorkGroupInitialRecords();

function generateWorkGroupInitialRecords()
{
    global $app_list_strings;

    $siteList = $app_list_strings['site_list'];
    $labSiteList = $app_list_strings['lab_site_list'];
    $trRoles = $app_list_strings['tr_roles_list'];
    $capaRoles = $app_list_strings['capa_roles_list'];
    $rrRoles = $app_list_strings['rr_roles_list'];

    foreach ($labSiteList as $labSiteKey => $labSiteValue) {
        if ($labSiteKey === '') {
            continue;
        }

        foreach ($trRoles as $key => $value) {
            if (! in_array($key, ['QuoteManager', 'RDManager', 'ColorMatchCoordinator', 'RegulatoryManager'])) {
                continue;
            }

            $assignedUserBean = retrieveSecurityGroupAssignedUser($value, $labSiteKey);

            if ($key == 'RegulatoryManager') {
                $value = 'Regulatory';
            }

            if (! checkIfRecordExists($value, 'TRWorkingGroup', $labSiteKey)) {
                $secGroupBean = BeanFactory::newBean('SecurityGroups');
                $secGroupBean->name = $value;
                $secGroupBean->type_c = 'TRWorkingGroup';
                $secGroupBean->site_c = $labSiteKey;
                $secGroupBean->division_c = 'ChromaColor';
                $secGroupBean->noninheritable = 1;
                $secGroupBean->description = 'TR Working Group Assignment';
                $secGroupBean->assigned_user_id = $assignedUserBean->id ?? '';
                $secGroupBean->save(false);
            }
        }
    }

    foreach ($capaRoles as $key => $value) {
        if (! in_array($key, ['CAPACoordinator', 'CustomerServiceManager', 'InternalAuditor', 'QualityControlManager', 'TechnicalServices'])) {
            continue;
        }

        // Since some workgroups (Ex. Technical Services) are not site dependent, skip from site loop
        if (! in_array($key, ['TechnicalServices'])) {
            foreach ($siteList as $siteKey => $siteValue) {
                if ($siteKey === '') {
                    continue;
                }

                $assignedUserBean = retrieveSecurityGroupAssignedUser($value, $siteKey);

                if (! checkIfRecordExists($value, 'CAPAWorkingGroup', $siteKey)) {
                    $secGroupBean = BeanFactory::newBean('SecurityGroups');
                    $secGroupBean->name = $value;
                    $secGroupBean->type_c = 'CAPAWorkingGroup';
                    $secGroupBean->site_c = $siteKey;
                    $secGroupBean->division_c = 'ChromaColor';
                    $secGroupBean->noninheritable = 1;
                    $secGroupBean->description = 'CAPA Working Group Assignment';
                    $secGroupBean->assigned_user_id = $assignedUserBean->id ?? '';
                    $secGroupBean->save(false);
                }
            }
        } else {
            $assignedUserBean = retrieveSecurityGroupAssignedUser($value);

            if (! checkIfRecordExists($value, 'CAPAWorkingGroup')) {
                $secGroupBean = BeanFactory::newBean('SecurityGroups');
                $secGroupBean->name = $value;
                $secGroupBean->type_c = 'CAPAWorkingGroup';
                $secGroupBean->site_c = NULL;
                $secGroupBean->division_c = 'ChromaColor';
                $secGroupBean->noninheritable = 1;
                $secGroupBean->description = 'CAPA Working Group Assignment';
                $secGroupBean->assigned_user_id = $assignedUserBean->id ?? '';
                $secGroupBean->save(false);
            }
        }
    }

    // Note: Regulatory Request does not have a site field
    foreach ($rrRoles as $key => $value) {
        if (! in_array($key, ['RegulatoryManager'])) {
            continue;
        }

        $assignedUserBean = retrieveSecurityGroupAssignedUser($value);

        if (! checkIfRecordExists($value, 'RRWorkingGroup')) {
            $secGroupBean = BeanFactory::newBean('SecurityGroups');
            $secGroupBean->name = $value;
            $secGroupBean->type_c = 'RRWorkingGroup';
            $secGroupBean->site_c = NULL;
            $secGroupBean->division_c = 'ChromaColor';
            $secGroupBean->noninheritable = 1;
            $secGroupBean->description = 'RR Working Group Assignment';
            $secGroupBean->assigned_user_id = $assignedUserBean->id ?? '';
            $secGroupBean->save(false);
        }
    }
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