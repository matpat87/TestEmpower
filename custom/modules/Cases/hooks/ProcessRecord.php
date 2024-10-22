<?php

require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');

class ProcessRecordHook 
{
    public function handleProductNumberColumn(&$bean, $event, $arguments)
    {
        global $log;

        $bean->load_relationship('ci_customeritems_cases_1');
        $beanList = $bean->ci_customeritems_cases_1->get();
        
        if (count($beanList) == 1) {
            $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $beanList[0]);
            
            $bean->ci_product_number_non_db = "
                <a href='index.php?module=CI_CustomerItems&action=DetailView&record={$customerProductBean->id}'>
                    <span class='sugar_field'>{$customerProductBean->product_number_c}</span>
                </a>";

        }
    }
    
    public function handleIssueNumberColumn(&$bean, $event, $arguments)
    {
        $bean->case_number =  "
            <a href='index.php?module=Cases&action=DetailView&record={$bean->id}'>
                <span class='sugar_field'>{$bean->case_number}</span>
            </a>";
    }

    public function handleReturnAuthorizationByColumn(&$bean, $event, $arguments)
    {
        $returnAuthorizationByUserBean = BeanFactory::getBean('Users', $bean->return_authorization_number_c);

        $bean->return_authorization_number_c =  ($returnAuthorizationByUserBean && $returnAuthorizationByUserBean->id)
            ? "
                <a href='index.php?module=Employees&action=DetailView&record={$returnAuthorizationByUserBean->id}'>
                    <span class='sugar_field'>{$returnAuthorizationByUserBean->full_name}</span>
                </a>"
            : '';
    }
  
}

?>