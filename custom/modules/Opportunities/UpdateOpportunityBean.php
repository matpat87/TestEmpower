<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

// Call function in browser: <url>/index.php?module=Opportunities&action=UpdateOpportunityBean
updateOpportunityBean();

function updateOpportunityBean()
{
    $opportunityBean = BeanFactory::getBean('Opportunities');
    $opportunityBeanList = $opportunityBean->get_full_list('', '', false, 0);

    if (count($opportunityBeanList) > 0) {
        foreach ($opportunityBeanList as $bean) {
            $opportunityTechnicalRequestsBeanList = TechnicalRequestHelper::get_opportunity_trs($bean->id);

            if (count($opportunityTechnicalRequestsBeanList) > 0) {
                TechnicalRequestHelper::opportunity_calculate_probability($bean->id);
            }

            //Load the relationship
            $bean->load_relationship('contacts');

            // Retrieve Opportunity - Contacts subpanel data and check if Primary Contact already exists in the subpanel
            $contactBeans = $bean->get_linked_beans(
                'contacts',
                'Contacts',
                array(),
                0,
                -1,
                0,
                "opportunities_contacts.contact_id = '{$bean->contact_id_c}'"
            );

            $contactBean = BeanFactory::getBean('Contacts', $bean->contact_id_c);

            // If the Primary Contact (Contact relate field) does not exist in the subpanel
            if (count($contactBeans) < 1) {
                ($contactBean && $contactBean->id) ? $bean->contacts->add($contactBean) : '';
            }
        }
    }
}