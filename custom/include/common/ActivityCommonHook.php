<?php

    class ActivityCommonHook{
        public function update_opp_last_act_date($bean, $event, $arguments){
            global $log;

            //for Opportunity
            if(!empty($bean->parent_type) && $bean->parent_type == 'Opportunities'){
                $log->fatal('Not an error - Logging Activity Hook for Opportunity');

                /*$opp_bean = BeanFactory::getBean('Opportunities', $bean->parent_id);

                if($opp_bean != null && !empty($opp_bean->id)){
                    $this->update_db_opp_last_act_date($opp_bean->id, $bean->date_entered);
                }
                */

                $this->update_opportunity($bean->parent_id, $bean->date_entered);
            }

            //for Technical Request
            if(!empty($bean->parent_type) && $bean->parent_type == 'TR_TechnicalRequests'){
                $log->fatal('Not an error - Logging Activity Hook for TR');

                $tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $bean->parent_id);

                if($tr_bean != null && !empty($tr_bean->id)){
                    $tr_bean->load_relationship('tr_technicalrequests_opportunities');
                    $opp_bean_list = $tr_bean->tr_technicalrequests_opportunities->getBeans();

                    if($opp_bean_list != null && count($opp_bean_list) > 0){
                        $opp_bean = array_values($opp_bean_list)[0];

                        $this->update_opportunity($opp_bean->id, $bean->date_entered);
                    }
                }
            }
        }

        private function update_opportunity($opp_id, $last_activity_date){
            $opp_bean = BeanFactory::getBean('Opportunities', $opp_id);

            if($opp_bean != null && !empty($opp_id)){
                $this->update_db_opp_last_act_date($opp_id, $last_activity_date);
            }
        }

        private function update_db_opp_last_act_date($opp_id, $last_activity_date){
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
    }

?>