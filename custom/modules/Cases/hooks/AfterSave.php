<?php

require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');

class CasesAfterSaveHook 
{
    public function saveRelatedInvoice(&$bean, $event, $arguments)
    {
        global $log;

        if ($bean->fetched_row['aos_invoices_cases_1aos_invoices_ida'] != $bean->aos_invoices_cases_1aos_invoices_ida && $bean->aos_invoices_cases_1aos_invoices_ida != "") {
            $invoiceBean = BeanFactory::getBean('AOS_Invoices', $bean->aos_invoices_cases_1aos_invoices_ida);
            //Load the relationship
            $bean->load_relationship('cases_aos_invoices_1');
            $bean->cases_aos_invoices_1->add($invoiceBean);
        }

        if ($bean->fetched_row['aos_invoices_cases_1aos_invoices_ida'] != $bean->aos_invoices_cases_1aos_invoices_ida && $bean->aos_invoices_cases_1aos_invoices_ida == "") {
            $invoiceBean = BeanFactory::getBean('AOS_Invoices', $bean->fetched_row['aos_invoices_cases_1aos_invoices_ida']);
            //Load the relationship
            $bean->load_relationship('cases_aos_invoices_1');
            $bean->cases_aos_invoices_1->delete($bean->id, $invoiceBean);
        }
    }
    
    // Save the selected Product to the subpanel
    // When removed in subpanel, it should also delete the product in the One to Many relationship table
    public function saveRelatedCustomerProduct(&$bean, $event, $arguments)
    {
        global $log;

        if ($bean->fetched_row['ci_customeritems_cases_1ci_customeritems_ida'] != $bean->ci_customeritems_cases_1ci_customeritems_ida && $bean->ci_customeritems_cases_1ci_customeritems_ida != "") {
            $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $bean->ci_customeritems_cases_1ci_customeritems_ida);
            //Load the relationship
            $bean->load_relationship('cases_ci_customeritems_1');
            $bean->cases_ci_customeritems_1->add($customerProductBean);
        }

        if ($bean->fetched_row['ci_customeritems_cases_1ci_customeritems_ida'] != $bean->ci_customeritems_cases_1ci_customeritems_ida && $bean->ci_customeritems_cases_1ci_customeritems_ida == "") {
            $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $bean->fetched_row['ci_customeritems_cases_1ci_customeritems_ida']);
            //Load the relationship
            $bean->load_relationship('cases_ci_customeritems_1');
            $bean->cases_ci_customeritems_1->delete($bean->id, $customerProductBean);
        }
    }
    
  
} // end of class

