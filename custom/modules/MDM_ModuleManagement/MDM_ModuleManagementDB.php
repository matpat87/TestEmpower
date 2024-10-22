<?php

class MDM_ModuleManagementDB{

    public function save($act_guid_list){
        global $log, $db;
        $to_insert = array();
        $to_update = array();

        if(!empty($act_guid_list) && count($act_guid_list) > 0){
            foreach($act_guid_list as &$act_guid){
                if(empty($act_guid['actionId'])){
                    $actionId = create_guid();
                    $this->insert_action($actionId, $act_guid['actionName'], $act_guid['moduleName']);
                    $act_guid['actionId'] = $actionId;
                }

                if(!$this->is_acl_roles_action_exist($act_guid)){
                    $to_insert[] = $act_guid;
                }
                else{
                    $to_update[] = $act_guid;
                }
            }
        }

        if(!empty($to_insert) && count($to_insert)> 0){
            $insert_query = $this->generate_insert_query($to_insert);
            $data = $db->query($insert_query);
        }

        if(!empty($to_update) && count($to_update)> 0){
            try {
                $to_update_chunks = array_chunk($to_update, 20, true);
                foreach($to_update_chunks as $to_update_chunk){
                    $update_query = $this->generate_update_query($to_update_chunk);
                    $data = $db->query($update_query);
                }
            }
            catch(Exception $e) {
                $log->fatal("Error in MDM_ModuleManagementDB.save. Details: " . $e->getMessage());
            }
        }
    }

    public function insert_action($actionId, $actionName, $moduleName, $aclAccess = '0'){
        global $db, $log, $current_user;
        $result = false;

        $query = "insert into acl_actions(id, date_entered, date_modified,
                    modified_user_id, created_by, name,
                    category, acltype, aclaccess, 
                    deleted)
                  values ('{$actionId}', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), 
                    '{$current_user->id}', '{$current_user->id}', '{$actionName}',
                    '{$moduleName}', 'module', '{$aclAccess}', 
                     '0') ";

        //$log->fatal($query);
        $db->query($query);
        //$result = true;

        return $result;
    }

    private function generate_insert_query($act_guid_list){
        global $log, $current_user;

        $result = '';

        if(!empty($act_guid_list) && count($act_guid_list) > 0){
            $result = 'insert into acl_roles_actions(id, role_id, action_id, 
                access_override, date_modified, deleted)
                values  ';

            foreach($act_guid_list as $act_guid){
                if(!empty($act_guid['actionId'])){
                    $new_guid = create_guid();
                    $result .= "( '{$new_guid}', '{$act_guid['roleId']}', '{$act_guid['actionId']}',
                    '{$act_guid['val']}', CURRENT_TIMESTAMP(), 0 ),";
                }
            }

            $result = substr($result, 0, (strlen($result) - 1));

            $result .= '';
        }

        return $result;
    }

    private function is_acl_roles_action_exist($act_guid){
        global $db, $log;
        $result = false;

        $query = "select count(*) as acl_count
                  from acl_roles_actions ara 
                  where ara.deleted = 0
                    and ara.role_id = '{$act_guid['roleId']}'
                    and ara.action_id = '{$act_guid['actionId']}' ";

        //$log->fatal($query);
        $data = $db->query($query);
        $rowData = $db->fetchByAssoc($data);

        if(!empty($rowData) && $rowData['acl_count'] == '1'){
            $result = true;
        }

        return $result;
    }

    private function generate_update_query($act_guid_list){
        global $log;

        $result = '';

        if(!empty($act_guid_list) && count($act_guid_list) > 0){
            $result = 'update acl_roles_actions set access_override = case ';

            foreach($act_guid_list as $act_guid){
                $result .= "when (action_id = '{$act_guid['actionId']}' and role_id = '{$act_guid['roleId']}') then {$act_guid['val']} ";
            }

            $result .= 'else `access_override` end where action_id in (';

            foreach($act_guid_list as $act_guid){
                $result .= "'{$act_guid['actionId']}',";
            }

            $result = substr($result, 0, (strlen($result) - 1));

            $result .= ') and role_id in (';

            foreach($act_guid_list as $act_guid){
                $result .= "'{$act_guid['roleId']}',";
            }

            $result = substr($result, 0, (strlen($result) - 1));

            $result .= ')';
        }

        //$log->fatal($result);

        return $result;
    }
}

?>