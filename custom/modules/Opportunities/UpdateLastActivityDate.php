<?php
    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    // Call function in browser: <url>/index.php?module=Opportunities&action=UpdateLastActivityDate

    class UpdateLastActivityDate{
        public function process(){
            $opp_list = $this->get_opportunties();

            echo count($opp_list) . '<br/><br/>';
            
            foreach($opp_list as $opp){
                echo "ID: {$opp['id']}<br/>";
                echo "Name: {$opp['name']}<br/>";
                echo "Last Activity Date: {$opp['last_activity_date_c']}<br/>";
                echo '<br/>';

                $last_activity = $this->get_activity($opp['id']);

                $tr_list = $this->get_trs($opp['id']);

                $last_activity_date_list = array();

                if(!empty($last_activity) && count($last_activity) > 0){
                    $last_activity_date_list[] = $last_activity['date_entered'];
                }

                foreach($tr_list as $tr){
                    $tr_last_activity = $this->get_activity($tr['id']);

                    if(!empty($tr_last_activity) && count($tr_last_activity) > 0){
                        $last_activity_date_list[] = $tr_last_activity['date_entered'];
                    }
                }

                usort($last_activity_date_list, "date_sort");

                $last_activity_date_list_ctr = count($last_activity_date_list);
                if(!empty($last_activity_date_list) && $last_activity_date_list_ctr > 0){
                    $this->update_opp_last_act_date($opp['id'], $last_activity_date_list[$last_activity_date_list_ctr - 1]);
                }
            }
        }

        private function get_trs($opp_id){
            global $db;

            $result = array();

            $sql = "select tt.id,
                        tt.date_entered
                    from tr_technicalrequests_opportunities_c tto
                    inner join tr_technicalrequests as tt
                        on tt.id = tto.tr_technicalrequests_opportunitiestr_technicalrequests_idb
                    where tto.deleted = 0
                        and tto.tr_technicalrequests_opportunitiesopportunities_ida = '{$opp_id}'; ";
            $data = $db->query($sql);
            
            while($row = $db->fetchByAssoc($data)){
                $result[] = $row;
            }

            return $result;
        }

        private function update_opp_last_act_date($opp_id, $last_activity_date){
            global $db;

            $now = date("Y-m-d H:i:s");

            $sql = "update opportunities 
                    left join opportunities_cstm
                        on opportunities_cstm.id_c = opportunities.id
                    set opportunities_cstm.last_activity_date_c = '{$last_activity_date}',
                        opportunities.date_modified = '{$now}',
                        opportunities.modified_user_id = '1'
                    where opportunities.id = '{$opp_id}' ";

            $result = $db->query($sql);

            return $result;
        }

        private function get_activity($parent_id){
            global $db;

            $result = array();
            $sql = "";
            $union_sql = "";
            $activityModules = ['calls', 'meetings', 'emails'];
	        $relatedModules = ['tr_technicalRequests'];

            for($i = 0; $i < count($activityModules); $i++){
                $union_sql .= "(SELECT id, 
                            date_entered 
                        FROM {$activityModules[$i]} 
                        WHERE deleted = 0 
                            AND parent_id = '{$parent_id}' 
                        order by date_entered desc 
                        limit 1) ";
                
                if($i < (count($activityModules) - 1)){
                    $union_sql .= "UNION ALL ";
                }
            }

            $sql = "select * 
                    from ({$union_sql}) us
                    order by us.date_entered desc
                    limit 1";

            $data = $db->query($sql);
            $result = $db->fetchByAssoc($data);

            return $result;
        }

        private function get_opportunties(){
            global $db;
            $result = array();

            $sql = "select o.id,
                        o.name,
                        oc.last_activity_date_c
                    from opportunities o
                    left join opportunities_cstm oc
                        on oc.id_c = o.id
                    where o.deleted = 0";

            $data = $db->query($sql);

            while($row = $db->fetchByAssoc($data)){
                $result[] = $row;
            }

            return $result;
        }
    }

    $updateLastActivityDate = new UpdateLastActivityDate();
    $updateLastActivityDate->process();

?>