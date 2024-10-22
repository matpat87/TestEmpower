<?php

    class OTR_OnTrackHelper{
        
        public static function is_id_exists($id)
        {
            global $db;
            $result = false;

            $data = $db->query("select id 
                from otw_otworkinggroups 
                where otw_otworkinggroups.id = '{$id}'");
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null && !empty($rowData['id']))
            {
                $result = true;
            }

            return $result;
        }

        public static function get_user($division, $role){
            global $db;
            $result = '';

            $data = $db->query("select id_c
                from users_cstm 
                where users_cstm.division_c = '{$division}'
                    and users_cstm.role_c = '{$role}' ");
            $rowData = $db->fetchByAssoc($data);
    
            if($rowData != null && !empty($rowData['id_c']))
            {
                $result = $rowData['id_c'];
            }

            return $result;
        }

        public static function get_ot_workinggroups($on_track_id){
            global $db;
            $result = array();

            $data = $db->query("select o.id,
                    o.name,
                    oc.ot_role_c
                from otw_otworkinggroups as o 
                inner join otw_otworkinggroups_cstm oc
                    on oc.id_c = o.id
                inner join otr_ontrack_otw_otworkinggroups_1_c as owg
                    on owg.deleted = 0
                        and owg.otr_ontrack_otw_otworkinggroups_1otw_otworkinggroups_idb = o.id
                where o.deleted = 0
                    and owg.otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida = '{$on_track_id}' ");
    
            while($rowData = $db->fetchByAssoc($data)){
                $result[] = $rowData;
            }

            return $result;
        }

        public static function is_workinggroup_role_exist($on_track_id, $role){
            $result = false;

            $ot_workinggroups = OTR_OnTrackHelper::get_ot_workinggroups($on_track_id);

            foreach($ot_workinggroups as $ot_workinggroup){
                if($ot_workinggroup['ot_role_c'] == $role){
                    $result = true;
                    break;
                }
            }

            return $result;
        }
    }

?>