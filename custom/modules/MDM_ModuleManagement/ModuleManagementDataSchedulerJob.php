<?php
    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    

    require_once('custom/modules/MDM_ModuleManagement/MDM_ModuleManagementDB.php');

    class ModuleManagementData{

        /*
        access	Time	module	89
        view	Time	module	90
        list	Time	module	90
        edit	Time	module	90
        delete	Time	module	90
        import	Time	module	90
        export	Time	module	90
        massupdate	Time	module	90
        */

        public function process(){
            global $log, $app_list_strings;
            $GLOBALS['log']->fatal('NOT AN ERROR - ModuleManagementData.process: Start');

            $module_list = $GLOBALS['moduleList'];

            $default_acl_actions = array(
                'access' => array(
                    'name' => 'access',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 89,
                ),
                'view' => array(
                    'name' => 'view',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 90,
                ),
                'list' => array(
                    'name' => 'list',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 90,
                ),
                'edit' => array(
                    'name' => 'edit',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 90,
                ),
                'delete' => array(
                    'name' => 'delete',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 90,
                ),
                'import' => array(
                    'name' => 'import',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 90,
                ),
                'export' => array(
                    'name' => 'export',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 90,
                ),
                'massupdate' => array(
                    'name' => 'massupdate',
                    'category' => '', //should be module name
                    'adtype' => 'module', //should be constant to 'module' value
                    'aclaccess' => 90,
                ),
            );

            if(!empty($module_list)){
                $arr_exempted = array('MDM_ModuleManagement', 'Calendar', 'ResourceCalendar', 'Home', 'AOBH_BusinessHours');

                $GLOBALS['log']->fatal('Processing Module Management Data: Start');
                foreach($module_list as $module){
                    if(!in_array($module, $arr_exempted)){
                        if(!$this->is_module_exist($module)){
                            $GLOBALS['log']->fatal('module' . ': ' . $module . ' does not exist');
                            $name = $app_list_strings['moduleList'][$module] ?? "" ;
                            $moduleManagementBean = BeanFactory::newBean('MDM_ModuleManagement');
                            $moduleManagementBean->name = $name;
                            $moduleManagementBean->module_c = $module;
                            $moduleManagementBean->save();
                            $GLOBALS['log']->fatal('module' . ': ' . $module . ' record in Module Management has been created.');
                        }
                    }
                }
                $GLOBALS['log']->fatal('Processing Module Management Data: End');

                $GLOBALS['log']->fatal('Processing ACL Access: Start');
                $moduleManagementDB = new MDM_ModuleManagementDB();

                foreach($module_list as $module){
                    if(!in_array($module, $arr_exempted)){
                        foreach($default_acl_actions as $default_acl_action_arr){
                            $default_acl_action_arr['category'] = $module;

                            if(!$this->is_acl_acess_exist($default_acl_action_arr)){
                                $GLOBALS['log']->fatal('module' . ': ' . $module . ' with access: '. $default_acl_action_arr['name'] .' does not exist');

                                $moduleManagementDB->insert_action(create_guid(), $default_acl_action_arr['name'], 
                                    $default_acl_action_arr['category'], $default_acl_action_arr['aclaccess']);

                                $GLOBALS['log']->fatal('module' . ': ' . $module . ' with access: '. $default_acl_action_arr['name'] .' record has been created');
                            }
                        }
                    }
                }
                $GLOBALS['log']->fatal('Processing ACL Access: End');
            }

            

            $GLOBALS['log']->fatal('NOT AN ERROR - ModuleManagementData.process: End');
        }

        private function is_acl_acess_exist($acl_acess){
            global $db, $log;
            $result = false;
    
            $name = $acl_acess['name'];
            $category = $acl_acess['category'];
            $query = "select count(*) as acl_access_count
                    from acl_actions aa
                    where aa.deleted = 0
                        and aa.name = '{$name}'
                        and aa.category = '{$category}' ";

            $data = $db->query($query);
            $rowData = $db->fetchByAssoc($data);
    
            if(!empty($rowData) && $rowData['acl_access_count'] == '1'){
                $result = true;
            }
    
            return $result;
        }

        private function is_module_exist($module_name){
            global $db, $log;
            $result = false;
    
            $query = "select count(*) as module_management_count
                    from mdm_modulemanagement mm
                    left join mdm_modulemanagement_cstm mmc 
                        on mmc.id_c = mm.id
                    where mm.deleted = 0
                        and mmc.module_c = '{$module_name}' ";
    
            $data = $db->query($query);
            $rowData = $db->fetchByAssoc($data);
    
            if(!empty($rowData) && $rowData['module_management_count'] == '1'){
                $result = true;
            }
    
            return $result;
        }
    }

    // $moduleManagementData = new ModuleManagementData();
	// $moduleManagementData->process();
?>