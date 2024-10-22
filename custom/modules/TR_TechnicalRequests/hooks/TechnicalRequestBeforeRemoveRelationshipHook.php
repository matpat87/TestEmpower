<?php
    require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

    class TechnicalRequestBeforeRemoveRelationshipHook{

        public function form_before_remove_relationship_save($bean, $event, $arguments)
        {
            global $log;

            $this->_calculate_opportunity_probability($bean);
        }

        private function _calculate_opportunity_probability($bean)
        {
            if(!empty($bean->tr_technicalrequests_opportunitiesopportunities_ida)){

                //get Previous Opportunity ID
                $tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $bean->id);
                $tr_bean->load_relationship('tr_technicalrequests_opportunities');
                $opportunities = $tr_bean->tr_technicalrequests_opportunities->getBeans();

                if(count($opportunities) > 0){
                    foreach($opportunities as $opportunity_bean)
                    {
                        TechnicalRequestHelper::opportunity_calculate_probability($opportunity_bean->id, null, $bean->id);
                    }
                }
            }
        }
    }
?>