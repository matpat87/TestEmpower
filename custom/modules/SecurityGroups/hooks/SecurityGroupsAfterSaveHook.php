<?php

class SecurityGroupsAfterSaveHook
{
    public function handleWorkGroupReassignment(&$bean, $event, $arguments)
    {
        global $app_list_strings;

        $acceptedWorkGroups = ['CAPAWorkingGroup', 'TRWorkingGroup', 'RRWorkingGroup'];

        if (! in_array($bean->type_c, $acceptedWorkGroups)) return true;

        // For some reason R&D Manager displays as R&amp;amp;D Manager on $bean->name
        // If we trigger htmlspecialchars_decode once it only shows as R&amp;D Manager
        // Triggering it twice returns as R&D Manager
        $decodedRoleValue = htmlspecialchars_decode(htmlspecialchars_decode($bean->name));

        if ($bean->fetched_row['assigned_user_id'] <> $bean->assigned_user_id) {
            if ($bean->type_c == 'CAPAWorkingGroup') {
                $roleKey = array_search($decodedRoleValue, $app_list_strings['capa_roles_list']);
                $this->handleCAPAWorkingGroupMassUpdate($roleKey, $bean);
                $this->handleCasesMassUpdate($roleKey, $bean);
            }

            if ($bean->type_c == 'TRWorkingGroup') {
                $roleKey = array_search($decodedRoleValue, $app_list_strings['tr_roles_list']);
                $this->handleTRWorkingGroupMassUpdate($roleKey, $bean);
                $this->handleTRMassUpdate($roleKey, $bean);
                $this->handleTRItemMassUpdate($roleKey, $bean);
                $this->handleDistroItemMassUpdate($roleKey, $bean);
            }

            if ($bean->type_c == 'RRWorkingGroup') {
                $roleKey = array_search($decodedRoleValue, $app_list_strings['rr_roles_list']);
                $this->handleRRWorkingGroupMassUpdate($roleKey, $bean);
                $this->handleRRMassUpdate($roleKey, $bean);
            }
        }
    }

    private function handleCAPAWorkingGroupMassUpdate($roleKey, $bean)
    {
        global $db;

        if (! $roleKey) return true;

        $siteCondition = ($bean->site_c) ? "AND cases_cstm.site_c = '{$bean->site_c}'" : '';

        $sql = "
            UPDATE cwg_capaworkinggroup
            INNER JOIN cases_cwg_capaworkinggroup_1_c 
                ON cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cwg_capaworkinggroup_idb = cwg_capaworkinggroup.id
                AND cases_cwg_capaworkinggroup_1_c.deleted = 0
            INNER JOIN cases 
                ON cases.id = cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cases_ida
                AND cases.deleted = 0
            LEFT JOIN cases_cstm 
                ON cases_cstm.id_c = cases.id 
            SET cwg_capaworkinggroup.parent_id = '{$bean->assigned_user_id}',
                cwg_capaworkinggroup.parent_type = 'Users'
            WHERE cwg_capaworkinggroup.deleted = 0 
                AND cwg_capaworkinggroup.parent_id = '{$bean->fetched_row['assigned_user_id']}'
                AND cwg_capaworkinggroup.capa_roles = '{$roleKey}'
                {$siteCondition}
                AND cases_cstm.division_c = '{$bean->division_c}'
                AND cases.status NOT IN ('Closed', 'Rejected', 'Cancelled', 'CreatedInError')
        ";

        $db->query($sql);
    }

    private function handleCasesMassUpdate($roleKey, $bean)
    {
        global $db;

        if (! $roleKey) return true;

        $siteCondition = ($bean->site_c) ? "AND cases_cstm.site_c = '{$bean->site_c}'" : '';

        $sql = "
            UPDATE cases 
            LEFT JOIN cases_cstm 
                ON cases.id = cases_cstm.id_c 
            INNER JOIN cases_cwg_capaworkinggroup_1_c 
                ON cases.id = cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cases_ida 
            INNER JOIN cwg_capaworkinggroup 
                ON cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cwg_capaworkinggroup_idb = cwg_capaworkinggroup.id 
                AND cwg_capaworkinggroup.deleted = 0
            SET cases.assigned_user_id = '{$bean->assigned_user_id}' 
            WHERE cases.deleted = 0 
                AND cases.assigned_user_id = '{$bean->fetched_row['assigned_user_id']}' 
                AND cwg_capaworkinggroup.capa_roles = '{$roleKey}' 
                {$siteCondition}
                AND cases_cstm.division_c = '{$bean->division_c}' 
                AND cases.status NOT IN ('Closed', 'Rejected', 'Cancelled', 'CreatedInError')
        ";

        $db->query($sql);
    }

    private function handleTRWorkingGroupMassUpdate($roleKey, $bean)
    {
        global $db;
        
        if (! $roleKey) return true;

        $siteCondition = ($bean->site_c) ? "AND tr_technicalrequests.site = '{$bean->site_c}'" : '';

        $sql = "
            UPDATE trwg_trworkinggroup 
            INNER JOIN tr_technicalrequests_trwg_trworkinggroup_1_c 
                ON trwg_trworkinggroup.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb
                AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
            INNER JOIN tr_technicalrequests 
                ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
                AND tr_technicalrequests.deleted = 0
            SET trwg_trworkinggroup.parent_id = '{$bean->assigned_user_id}',
                trwg_trworkinggroup.parent_type = 'Users'
            WHERE trwg_trworkinggroup.deleted = 0 
                AND trwg_trworkinggroup.parent_id = '{$bean->fetched_row['assigned_user_id']}'
                AND trwg_trworkinggroup.tr_roles = '{$roleKey}'
                {$siteCondition}
                AND tr_technicalrequests.division = '{$bean->division_c}'
                AND tr_technicalrequests.approval_stage NOT IN ('closed', 'closed_won', 'closed_lost', 'closed_rejected')
        ";
        
        $db->query($sql);
    }

    private function handleTRMassUpdate($roleKey, $bean)
    {
        global $db;

        if (! $roleKey) return true;

        $siteCondition = ($bean->site_c) ? "AND tr_technicalrequests.site = '{$bean->site_c}'" : '';

        $sql = "
            UPDATE tr_technicalrequests 
            INNER JOIN tr_technicalrequests_trwg_trworkinggroup_1_c 
                ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
                AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
            INNER JOIN trwg_trworkinggroup
                ON trwg_trworkinggroup.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb
                AND trwg_trworkinggroup.deleted = 0
            SET tr_technicalrequests.assigned_user_id = '{$bean->assigned_user_id}'
            WHERE tr_technicalrequests.deleted = 0
                AND tr_technicalrequests.assigned_user_id = '{$bean->fetched_row['assigned_user_id']}'
                AND trwg_trworkinggroup.tr_roles = '{$roleKey}'
                {$siteCondition}
                AND tr_technicalrequests.division = '{$bean->division_c}'
                AND tr_technicalrequests.approval_stage NOT IN ('closed', 'closed_won', 'closed_lost', 'closed_rejected')
        ";

        $db->query($sql);
    }

    private function handleTRItemMassUpdate($roleKey, $bean)
    {
        global $db;

        if (! $roleKey) return true;

        $siteCondition = ($bean->site_c) ? "AND tr_technicalrequests.site = '{$bean->site_c}'" : '';

        $sql = "
            UPDATE tri_technicalrequestitems
            INNER JOIN tri_technicalrequestitems_tr_technicalrequests_c 
                ON tri_technicalrequestitems.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_technif81bstitems_idb
                AND tri_technicalrequestitems_tr_technicalrequests_c.deleted = 0
            INNER JOIN tr_technicalrequests
                ON tr_technicalrequests.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_techni0387equests_ida
                AND tr_technicalrequests.deleted = 0
            INNER JOIN tr_technicalrequests_trwg_trworkinggroup_1_c 
                ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
                AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
            INNER JOIN trwg_trworkinggroup
                ON trwg_trworkinggroup.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb
                AND trwg_trworkinggroup.deleted = 0
            SET tri_technicalrequestitems.assigned_user_id = '{$bean->assigned_user_id}'
            WHERE tri_technicalrequestitems.deleted = 0
                AND tri_technicalrequestitems.assigned_user_id = '{$bean->fetched_row['assigned_user_id']}'
                AND trwg_trworkinggroup.tr_roles = '{$roleKey}'
                {$siteCondition}
                AND tr_technicalrequests.division = '{$bean->division_c}'
                AND tr_technicalrequests.approval_stage NOT IN ('closed', 'closed_won', 'closed_lost', 'closed_rejected')
                AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected')
        ";

        $db->query($sql);
    }

    private function handleDistroItemMassUpdate($roleKey, $bean)
    {
        global $db;

        if (! $roleKey) return true;

        $siteCondition = ($bean->site_c) ? "AND tr_technicalrequests.site = '{$bean->site_c}'" : '';

        $sql = "
            UPDATE dsbtn_distributionitems 
            LEFT JOIN dsbtn_distributionitems_cstm 
                ON dsbtn_distributionitems.id = dsbtn_distributionitems_cstm.id_c
            INNER JOIN dsbtn_distribution
                ON dsbtn_distribution.id = dsbtn_distributionitems_cstm.dsbtn_distribution_id_c
                AND dsbtn_distribution.deleted = 0
            LEFT JOIN dsbtn_distribution_cstm
                ON dsbtn_distribution.id = dsbtn_distribution_cstm.id_c
            INNER JOIN tr_technicalrequests
                ON tr_technicalrequests.id = dsbtn_distribution_cstm.tr_technicalrequests_id_c
                AND tr_technicalrequests.deleted = 0
            INNER JOIN tr_technicalrequests_trwg_trworkinggroup_1_c 
                ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
                AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
            INNER JOIN trwg_trworkinggroup
                ON trwg_trworkinggroup.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb
                AND trwg_trworkinggroup.deleted = 0
            SET dsbtn_distributionitems.assigned_user_id = '{$bean->assigned_user_id}'
            WHERE dsbtn_distributionitems.deleted = 0
                AND dsbtn_distributionitems.assigned_user_id = '{$bean->fetched_row['assigned_user_id']}'
                AND trwg_trworkinggroup.tr_roles = '{$roleKey}'
                {$siteCondition}
                AND tr_technicalrequests.division = '{$bean->division_c}'
                AND tr_technicalrequests.approval_stage NOT IN ('closed', 'closed_won', 'closed_lost', 'closed_rejected')
                AND dsbtn_distributionitems_cstm.status_c NOT IN ('complete', 'rejected')
        ";

        $db->query($sql);
    }

    private function handleRRWorkingGroupMassUpdate($roleKey, $bean)
    {
        global $db;

        if (! $roleKey) return true;

        $sql = "
            UPDATE rrwg_rrworkinggroup 
            INNER JOIN rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c 
                ON rrwg_rrworkinggroup.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regulaffdanggroup_idb
                AND rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.deleted = 0
            INNER JOIN rrq_regulatoryrequests 
                ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regula2443equests_ida
                AND rrq_regulatoryrequests.deleted = 0
            LEFT JOIN rrq_regulatoryrequests_cstm
                ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_cstm.id_c
            SET rrwg_rrworkinggroup.parent_id = '{$bean->assigned_user_id}',
                rrwg_rrworkinggroup.parent_type = 'Users'
            WHERE rrwg_rrworkinggroup.deleted = 0 
                AND rrwg_rrworkinggroup.parent_id = '{$bean->fetched_row['assigned_user_id']}'
                AND rrwg_rrworkinggroup.rr_roles = '{$roleKey}'
                AND rrq_regulatoryrequests_cstm.division_c = '{$bean->division_c}'
                AND rrq_regulatoryrequests_cstm.status_c NOT IN ('complete', 'rejected', 'created_in_error')
        ";

        $db->query($sql);
    }

    private function handleRRMassUpdate($roleKey, $bean)
    {
        global $db;

        if (! $roleKey) return true;

        $sql = "
            UPDATE rrq_regulatoryrequests 
            LEFT JOIN rrq_regulatoryrequests_cstm
                ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_cstm.id_c
            INNER JOIN rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c 
                ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regula2443equests_ida
                AND rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.deleted = 0
            INNER JOIN rrwg_rrworkinggroup
                ON rrwg_rrworkinggroup.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regulaffdanggroup_idb
                AND rrwg_rrworkinggroup.deleted = 0
            SET rrq_regulatoryrequests.assigned_user_id = '{$bean->assigned_user_id}'
            WHERE rrq_regulatoryrequests.deleted = 0 
                AND rrq_regulatoryrequests.assigned_user_id = '{$bean->fetched_row['assigned_user_id']}'
                AND rrwg_rrworkinggroup.rr_roles = '{$roleKey}'
                AND rrq_regulatoryrequests_cstm.division_c = '{$bean->division_c}'
                AND rrq_regulatoryrequests_cstm.status_c NOT IN ('complete', 'rejected', 'created_in_error')
        ";

        $db->query($sql);
    }
}