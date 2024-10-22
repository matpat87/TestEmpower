<?php
    require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

    class OpportunitiesAfterAddRelationshipHook{

        public function form_after_add_relationship_save($bean, $event, $arguments)
        {
            global $log;

            $this->_calculate_opportunity_probability($bean);
        }

        private function _calculate_opportunity_probability($bean)
        {
            global $log;

            if($bean != null && $bean->module_name == 'Opportunities'){
                $opportunity_bean = BeanFactory::getBean('Opportunities', $bean->id);
                $tr_related_beans = TechnicalRequestHelper::get_opportunity_trs($bean->id);

                if(count($tr_related_beans) > 0){
                    TechnicalRequestHelper::opportunity_calculate_probability($bean->id, $bean);
                }
            }
        }
    }
?>