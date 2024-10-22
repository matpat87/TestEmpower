<?php
function getTrackers($date,$user_id,$module){
    global $db ,$sugar_config;
    
        $rows=array();
        if ($module == 'Meetings'){
	        $query = "SELECT  id,name,date_start,jjwg_maps_geocode_status_c,jjwg_maps_address_c,jjwg_maps_lat_c,jjwg_maps_lng_c
                        FROM meetings
                        JOIN meetings_cstm mc ON mc.id_c=meetings.id
                        LEFT JOIN  meetings_users m_u on m_u.meeting_id = meetings.id
                        WHERE (jjwg_maps_geocode_status_c like 'OK' or jjwg_maps_geocode_status_c like 'APPROXIMATE') and (meetings.assigned_user_id = '$user_id' OR m_u.user_id ='$user_id)) ORDER BY date_start";
        }
        else {
	        $query = "SELECT  id,name,date_entered,jjwg_maps_geocode_status_c,jjwg_maps_address_c,jjwg_maps_lat_c,jjwg_maps_lng_c
                        FROM qcrm_tracker m
                        JOIN qcrm_tracker_cstm mc ON mc.id_c=m.id
                        WHERE (jjwg_maps_geocode_status_c like 'OK' or jjwg_maps_geocode_status_c like 'APPROXIMATE') AND date_entered LIKE '$date%' AND m.assigned_user_id = '$user_id' ORDER BY date_entered";
        }

        $list = $db->query($query);
        while ($res = $db->fetchByAssoc($list)){
        	$rows[]=$res;
        }
        
        echo json_encode($rows);
}
getTrackers($_POST['date'],$_POST['user'],$_POST['module']);

 