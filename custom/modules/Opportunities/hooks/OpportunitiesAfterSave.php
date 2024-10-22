<?php

require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

class OpportunitiesAfterSave {
    function redirectNewAccountOpportunity(&$bean, $event, $arguments)
    {
        // If new record is generated from Account - Opportunities Subpanel, redirect to Opportunity Detail View
        if (! $bean->fetched_row['id'] && $_REQUEST['return_module'] == 'Accounts') {
            $params = [
                'module'=> 'Opportunities',
                'action'=>'DetailView', 
                'record' => $bean->id
            ];

            SugarApplication::redirect('index.php?' . http_build_query($params));
        }
    }

    function handleTRDataMap(&$bean, $event, $arguments)
    {
        if (($bean->rel_fields_before_value['account_id'] != $bean->account_id) || ($bean->fetched_row['contact_id_c'] != $bean->contact_id_c)) {
            $bean->load_relationship('tr_technicalrequests_opportunities');
            $trBeans = $bean->tr_technicalrequests_opportunities->getBeans();

            if (isset($trBeans) && $trBeans) {
                $_REQUEST['skip_redirect'] = true; // Used to bypass TR -> TR Workgroup Logic hook that redirects user to detailview which kills loop process

                foreach ($trBeans as $trBean) {
                    $trBean->tr_technicalrequests_accountsaccounts_ida = ($bean->rel_fields_before_value['account_id'] != $bean->account_id) ? $bean->account_id : $trBean->tr_technicalrequests_accountsaccounts_ida;
                    $trBean->contact_id1_c = ($bean->fetched_row['contact_id_c'] != $bean->contact_id_c) ? $bean->contact_id_c : $trBean->contact_id1_c;
                    $trBean->save();
                }
            }
        }
    }

    function handleLinkPrimaryContactToSubpanel(&$bean, $event, $arguments)
    {
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

        // If the Primary Contact (Contact relate field) has been changed
        if (($bean->fetched_row['contact_id_c'] != $bean->contact_id_c)) {
            $previousContactBean = BeanFactory::getBean('Contacts', $bean->fetched_row['contact_id_c']);

            // Set New Contact Bean
            ($previousContactBean && $previousContactBean->id ) ? $bean->contacts->delete($bean->id, $previousContactBean) : '';
            
            // Set New Contact Bean
            ($contactBean && $contactBean->id) ? $bean->contacts->add($contactBean) : '';
        }
    }
}

?>