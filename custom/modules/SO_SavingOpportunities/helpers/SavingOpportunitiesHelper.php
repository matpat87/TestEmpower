<?php
    class SavingOpportunitiesHelper {
        public static function assign_opportunity_id($opportunity_id = '')
        {
            global $db;
            $result = 0;
            $opportunity_bean = BeanFactory::getBean('SO_SavingOpportunities');
            
            $opportunity_bean_list = $opportunity_bean->get_full_list('id', "so_savingopportunities.id = '{$opportunity_id}'", false, 0);
    
            if(!empty($opportunity_bean_list) && count($opportunity_bean_list) > 0){
                $result = $opportunity_bean_list[0]->so_id;
            } else {
                $data = $db->query("select so_id 
                    from so_savingopportunities
                    order by so_id desc
                    limit 1");
                $rowData = $db->fetchByAssoc($data);
        
                if($rowData != null)
                {
                    $result = $rowData['so_id'];
                }
                
                $result += 1;
            }
    
            return $result;
        } 
    }
?>