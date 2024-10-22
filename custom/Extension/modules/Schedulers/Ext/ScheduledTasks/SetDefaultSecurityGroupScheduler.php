<?php
    require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');
    $job_strings[] = 'setDefaultSecurityGroupScheduler';

    function setDefaultSecurityGroupScheduler(){
        global $app_list_strings, $log;
        
        $log->fatal('Non an error - setDefaultSecurityGroupScheduler: start');

        ini_set('max_execution_time', 3600); //set max execution time to 3600 or 1 hr to process big records

        $modules = array('ODR_SalesOrders', 'AOS_Invoices');
        $divisions = select_divisions();
        

        foreach($modules as $module){
            $log->fatal("Non an error - Module Name: {$module} start");
            $time_start = microtime(true); 

            $defaultSecGroupSettings = SecurityGroupHelper::selectDefaultSecurityGroups($module);

            foreach($divisions as $division){
                $log->fatal("Non an error - Division : {$division}");

                $divisionLabel = !empty($app_list_strings['user_division_list'][$division]) ? $app_list_strings['user_division_list'][$division] : '';
                $division_records_per_module  = array();

                $securitygroupDivisionBean = BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
                    array(
                        "division_c" => $division,
                        "type_c" => "Division Access",
                        "name" => "Level II - {$divisionLabel} Management"
                    ), false, true
                );

                if(!empty($securitygroupDivisionBean)){

                    if($module == 'ODR_SalesOrders'){
                        $division_records_per_module = select_orders_by_division($division, $securitygroupDivisionBean->id);
                    }
                    else if($module == 'AOS_Invoices'){
                        $division_records_per_module = select_invoices_by_division($division, $securitygroupDivisionBean->id);
                    }

                    $division_records_per_module_count = count($division_records_per_module);
                    $log->fatal("Non an error - Division Count : {$division_records_per_module_count}");

                    $is_exist = false;
                    foreach($division_records_per_module as $module_id => $records_per_module){ 
                        $is_exist = false;

                        foreach($records_per_module as $security_group){
                            if($security_group['securitygroup_id'] == $securitygroupDivisionBean->id){
                                $is_exist = true;
                                break;
                            }
                        }

                        //SK 2021-10-19 - To Remove this if not for testing
                        //if($module_id == '000ecf9f-f451-4614-bf1c-8c14386f6506'){
                            //echo 'Module ID: ' . $module_id . '<br/>';
                            //echo 'Default Security ID: ' . $securitygroupDivisionBean->id . '<br/>';
                            
                            if(!$is_exist){
                                $log->fatal("Non an error - Record ID: {$module_id}, Security Group ID: {$securitygroupDivisionBean->id} does not exist");
                                $eventLogId = create_guid();
                                SecurityGroupHelper::insertOrDeleteSecurityGroupRecord('insert', $securitygroupDivisionBean->id, $module_id, 
                                    $module, $eventLogId);
                                $log->fatal("Non an error - Inserted Record ID: {$module_id}, Security Group ID: {$securitygroupDivisionBean->id}");
                            }
                        //}

                        //Adding Default Security Group Settings Per Record
                        $is_default_sec_group_settings_exist = false;
                        foreach($defaultSecGroupSettings as $defaultSecGroupSetting){
                            $is_default_sec_group_settings_exist = false;

                            foreach($records_per_module as $security_group){
                                if($security_group['securitygroup_id'] == $defaultSecGroupSetting['securitygroup_id']){
                                    $is_default_sec_group_settings_exist = true;
                                    break;
                                }
                            }

                            if(!$is_default_sec_group_settings_exist){
                                $log->fatal("Non an error - Record ID: {$module_id}, Security Group ID: {$defaultSecGroupSetting['securitygroup_id']} does not exist");
                                $eventLogId = create_guid();
                                SecurityGroupHelper::insertOrDeleteSecurityGroupRecord('insert', $defaultSecGroupSetting['securitygroup_id'], $module_id, 
                                    $module, $eventLogId);
                                $log->fatal("Non an error - Inserted Record ID: {$module_id}, Default Security Group Settings ID: {$defaultSecGroupSetting['securitygroup_id']}");
                            }
                        }
                    }
                

                    $exempted_security_groups = array('0' => $securitygroupDivisionBean->id);
                    foreach($defaultSecGroupSettings as $defaultSecGroupSetting){
                        $exempted_security_groups[] = $defaultSecGroupSetting['securitygroup_id'];
                    }

                    $acc_div_sec_groups = select_accounts_security_groups($division, $exempted_security_groups);

                    $is_security_group_exist = false;
                    $account_id = '';
                    $account_name = '';
                    $security_group_id = '';
                    $security_group_name = '';
                    
                    foreach($division_records_per_module as $module_id => $records_per_module){
                        $account_id = get_account_per_records($records_per_module);
                        $acc_sec_groups = get_account_security_groups($account_id, $acc_div_sec_groups); //parent

                        $is_exist = false;
                        $account_id = '';
                        $account_name = '';
                        $security_group_id = '';
                        $security_group_name = '';
                        foreach($acc_sec_groups as $acc_sec_group){
                            $account_id = $acc_sec_group['account_id'];
                            $account_name = $acc_sec_group['account_name'];
                            $security_group_id = $acc_sec_group['securitygroup_id'];
                            $security_group_name = $acc_sec_group['securitygroup_name'];

                            foreach($records_per_module as $security_group){
                                if($acc_sec_group['securitygroup_id'] == $security_group['securitygroup_id']){
                                    $is_exist = true;
                                    break 2;
                                }
                            }
                        }

                        if(!$is_exist 
                            && !empty($account_id)
                            && !empty($security_group_id)){
                            $log->fatal("Non an error - Record ID: {$module_id}, Security Group ID: {$security_group_id} does not exist in Account Level");
                            $log->fatal('Module ID: ' . $module_id);
                            $log->fatal('Account ID: ' . $account_id);
                            $log->fatal('Account Name: ' . $account_name);
                            $log->fatal('Security Group ID: ' . $security_group_id);
                            $log->fatal('Security Group Name: ' . $security_group_name);
                            $eventLogId = create_guid();
                            SecurityGroupHelper::insertOrDeleteSecurityGroupRecord('insert', $security_group_id, $module_id, 
                                    $module, $eventLogId);
                            $log->fatal("Non an error - Inserted Record ID: {$module_id}, Account Security Group Settings ID: {$security_group_id}");
                        }
                    }
                }
                
            }

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start) / 60; //in minutes
            $execution_time = number_format((float)$execution_time, 2, '.', '');
            $log->fatal("Non an error - {$module} Time execution: {$execution_time} min(s)");
        }

        $log->fatal("Non an error - setDefaultSecurityGroupScheduler: end");

        return true;
    }

    function get_account_per_records($records_per_module){
        $result = '';

        foreach($records_per_module as $security_group){
            if(!empty($security_group['account_id'])){
                $result = $security_group['account_id'];
                break;
            }
        }

        return $result;
    }

    function get_account_security_groups($account_id, $account_security_groups){
        $result = array();

        foreach($account_security_groups as $account_security_group){
            if($account_security_group['account_id'] == $account_id){
                $result[] = array( 
                    'securitygroup_id' => $account_security_group['securitygroup_id'],
                    'securitygroup_name' => $account_security_group['securitygroup_name'],
                    'account_id' => $account_security_group['account_id'],
                    'account_name' => $account_security_group['account_name'],
                );
            }
        }

        return $result;
    }

    function select_accounts_security_groups($division, $exempted_security_groups){
        $result = array();
        global $db, $log;

        $exempted_security_groups_where = 's.id not in (';
        if(count($exempted_security_groups) > 0){
            foreach($exempted_security_groups as $exempted_security_group){
                $exempted_security_groups_where .= "'{$exempted_security_group}',";
            }

            $exempted_security_groups_where = substr($exempted_security_groups_where, 0, strlen($exempted_security_groups_where) -1 );
        }
        $exempted_security_groups_where .= ')';

        $query = "select a.id as account_id,
                    a.name as account_name,
                    s.id as securitygroup_id,
                    s.name as securitygroup_name
                from accounts a
                inner join accounts_cstm ac
                    on ac.division_c = '{$division}'
                        and ac.id_c = a.id
                inner join securitygroups_records sr
                    on  sr.deleted = 0
                        and sr.module = 'Accounts'
                        and sr.record_id = a.id
                inner join securitygroups s
                    on s.deleted = 0 
                        and s.id = sr.securitygroup_id
                where a.deleted = 0
                    and ac.division_c = '{$division}' 
                    and {$exempted_security_groups_where}
                order by a.id";
        $data = $db->query($query);

        while($rowData = $db->fetchByAssoc($data)){
            $result[] = $rowData;
        }

        return $result;
    }

    function select_invoices_by_division($division, $security_group_id){
        $result = array();
        global $db;

        $query = "select ai.id as invoice_id, 
                    ai.name as invoice_name,
                    sr.securitygroup_id as securitygroup_id,
                    a.id as account_id,
                    a.name as account_name
                from aos_invoices ai
                left join accounts as a
                on a.id = ai.billing_account_id
                left join accounts_cstm ac
                on ac.id_c = a.id
                left join securitygroups_records sr
                on sr.record_id = ai.id
                    and sr.deleted = 0
                    and sr.module = 'AOS_Invoices'
                left join securitygroups s
                on s.id = sr.securitygroup_id
                left join securitygroups_cstm sc
                on sc.id_c = s.id
                    and sc.division_c = '{$division}'
                where ai.deleted = 0 
                and ac.division_c = '{$division}';
                
                -- and s.id = '{$security_group_id}' ";
        $data = $db->query($query);
        
        while($rowData = $db->fetchByAssoc($data)){

            $result[$rowData['invoice_id']][] = array(
                'invoice_id' => $rowData['invoice_id'],
                'invoice_name' => $rowData['invoice_name'],
                'securitygroup_id' => $rowData['securitygroup_id'],
                'account_id' => $rowData['account_id'],
                'account_name' => $rowData['account_name'],
            );
        }

        return $result;
    }

    function select_orders_by_division($division, $security_group_id){
        $result = array();
        global $db;

        $query = "select os.id as order_id, 
                    os.name as order_name,
                    sr.securitygroup_id as securitygroup_id,
                    a.id as account_id,
                    a.name as account_name
            from odr_salesorders os
            left join accounts_odr_salesorders_1_c aos
                on aos.accounts_odr_salesorders_1odr_salesorders_idb = os.id
            left join accounts as a
                on a.id = aos.accounts_odr_salesorders_1accounts_ida
            left join accounts_cstm ac
                on ac.id_c = a.id
            left join securitygroups_records sr
                on sr.record_id = os.id
                    and sr.deleted = 0
                    and sr.module = 'ODR_SalesOrders'
            left join securitygroups s
                on s.id = sr.securitygroup_id
            left join securitygroups_cstm sc
                on sc.id_c = s.id
                    and sc.division_c = '{$division}'
            where os.deleted = 0 
                and ac.division_c = '{$division}'
                
                -- and s.id = '{$security_group_id}' ";
        $data = $db->query($query);
        
        while($rowData = $db->fetchByAssoc($data)){

            $result[$rowData['order_id']][] = array(
                'order_id' => $rowData['order_id'],
                'order_name' => $rowData['order_name'],
                'securitygroup_id' => $rowData['securitygroup_id'],
                'account_id' => $rowData['account_id'],
                'account_name' => $rowData['account_name'],
            );
        }

        return $result;
    }

    function select_divisions(){
        $result = array();
        global $db;

        $query = "select distinct division_c as division
                    from accounts_cstm
                    where division_c <> '' or division_c <> null";
        $data = $db->query($query);
        
        while($rowData = $db->fetchByAssoc($data)){
            $result[] = $rowData['division'];
        }

        return $result;
    }
?>