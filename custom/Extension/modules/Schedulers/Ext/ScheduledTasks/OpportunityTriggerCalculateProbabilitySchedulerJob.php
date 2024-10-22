<?php

handleVerifyBeforeRequire('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

class OpportunityTriggerCalculateProbabilitySchedulerJob implements RunnableSchedulerJob
{
    public function run($arguments)
    {
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT opportunities.id FROM opportunities WHERE opportunities.deleted = 0";
        $result = $db->query($sql); 

        while ($row = $db->fetchByAssoc($result)) {
            $opportunityBean = BeanFactory::getBean('Opportunities', $row['id']);

            if ($opportunityBean && $opportunityBean->id) {
                $opportunityTechnicalRequestsBeanList = TechnicalRequestHelper::get_opportunity_trs($opportunityBean->id);

                if (count($opportunityTechnicalRequestsBeanList) > 0) {
                    TechnicalRequestHelper::opportunity_calculate_probability($opportunityBean->id);
                }
            }
        }

        return true;
    }

    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
}