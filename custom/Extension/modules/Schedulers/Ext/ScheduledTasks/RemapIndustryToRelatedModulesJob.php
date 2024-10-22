<?php

class RemapIndustryToRelatedModulesJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    
    $db = DBManagerFactory::getInstance();
    $industryIds = include 'custom/modules/MKT_Markets/metadata/custom_industry_array.php'; // array of static industry ids from excel file uploaded in Ontrack #1478
    /**
     * Update industry and sub_industry_c values for Modules: Opportunity and CI_CustomerItems (Customer Products)
     * 
     */
    foreach ($industryIds as $id) {

        $currentIndustryBean = BeanFactory::getBean('MKT_Markets', $id['old_id']);
        $newIndustryBean = BeanFactory::getBean('MKT_Markets', $id['new_id']);
       
        if ($currentIndustryBean && $currentIndustryBean->id || $newIndustryBean && $newIndustryBean->id) {

            // retrieve all Opportunities where industry = $industry AND sub_industry_c = $id['old_id']
            $opportunityBean = BeanFactory::getBean('Opportunities');
            $opportunityBeanList = $opportunityBean->get_full_list('name', "opportunities_cstm.sub_industry_c = '{$id['old_id']}'");
            
            // retrieve all Customer Products where industry = $industry AND sub_industry_c = $id['old_id']
            $customerProductBean = BeanFactory::getBean('CI_CustomerItems');
            $customerProductBeanList = $customerProductBean->get_full_list('name', "ci_customeritems_cstm.sub_industry_c = '{$id['old_id']}'");

            if (is_array($opportunityBeanList) && count($opportunityBeanList) > 0) {
                $oppIds = implode("','", array_column($opportunityBeanList, 'id'));

                $oppUpdateSql = "
                    UPDATE opportunities
                            LEFT JOIN
                        opportunities_cstm ON opportunities.id = opportunities_cstm.id_c 
                    SET 
                        opportunities_cstm.industry_c = '{$newIndustryBean->name}',
                        opportunities_cstm.sub_industry_c = '{$newIndustryBean->id}'
                    WHERE
                        opportunities.id IN ('{$oppIds}')               
                ";
                $db->query($oppUpdateSql);
            }
            
            if (is_array($customerProductBeanList) && count($customerProductBeanList) > 0) {
                $ciItems_ids = implode("','", array_column($customerProductBeanList, 'id'));

                $ciUpdateSql = "
                    UPDATE ci_customeritems
                            LEFT JOIN
                        ci_customeritems_cstm ON ci_customeritems.id = ci_customeritems_cstm.id_c 
                    SET 
                        ci_customeritems_cstm.industry_c = '{$newIndustryBean->name}',
                        ci_customeritems_cstm.sub_industry_c = '{$newIndustryBean->id}'
                    WHERE
                        ci_customeritems.id IN ('{$ciItems_ids}')               
                ";

                
                $db->query($ciUpdateSql);
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