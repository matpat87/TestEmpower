<?php

      class OpportunitiesHelper{
        public static function get_status($stage)
        {
            global $app_list_strings;
            $result = array();

            if($stage == 'IdentifyingOpportunity')
            {
                $result['in_process'] = 'In Process';
            }
            else if($stage == 'UnderstandingRequirements')
            {
                $result['in_process'] = $app_list_strings['tr_technicalrequests_status_list']['in_process'];
            }
            else if($stage == 'SolutionDevelopment')
            {
                $result['new'] = '0 - New';
                $result['approved'] = '1 - Approved ready for Development';
                $result['in_process'] = '2 - In Process';
                $result['awaiting_target_resin'] = 'Awaiting Target/Resin';
                $result['more_information'] = 'More Information Required';
            }
            else if($stage == 'Closed')
            {
                $result['chip_sample_complete'] = $app_list_strings['tr_technicalrequests_status_list']['chip_sample_complete'];
            }
            else if($stage == 'QuotingProposing')
            {
                $result['new'] = '0 - New';
                $result['chips_submitted_for_customer_approval'] = '1 - Chips Submitted for Customer Approval';
                $result['chips_approved'] = '2 - Chips Approved';
                $result['quote_available'] = '3 - Quote Available';
                $result['quote_submitted_for_customer_approval'] = '4 - Quote Submitted for Customer Approval';
                $result['quote_approved'] = '5 - Quote Approved';
            }
            else if($stage == 'Sampling')
            {
                $result['new'] = '0 - New';
                $result['sample_submitted_for_customer_approval'] = '1 - Sample Submitted for Customer Approval';
                $result['sample_approved'] = '2 - Sample Approved';
            }
            else if($stage == 'ProductionTrialOrder')
            {
                $result['new'] = '0 - New';
                $result['first_order_submitted_for_customer_approval'] = '1 - First order Submitted for Customer Approval';
                $result['approved'] = '2 - Approved';
            }
            else if($stage == 'AwardEminent')
            {
                $result['awaiting_award'] = '1 - Awaiting Award';
            }
            else if($stage == 'ClosedWon')
            {
                $result['order_received'] = $app_list_strings['tr_technicalrequests_status_list']['order_received'];
                $result['qualified_source'] = $app_list_strings['tr_technicalrequests_status_list']['qualified_source'];
            }
            else if($stage == 'ClosedLost')
            {
                $result[''] = '';
                $result['color'] = $app_list_strings['tr_technicalrequests_status_list']['color'];
                $result['price'] = $app_list_strings['tr_technicalrequests_status_list']['price'];
                $result['performance'] = $app_list_strings['tr_technicalrequests_status_list']['performance'];
                $result['service'] = $app_list_strings['tr_technicalrequests_status_list']['service'];
                $result['competition'] = $app_list_strings['tr_technicalrequests_status_list']['competition'];
                $result['cancelled'] = $app_list_strings['tr_technicalrequests_status_list']['cancelled'];
            }
            else if($stage == 'ClosedRejected')
            {
                $result[''] = '';
                $result['capability'] = $app_list_strings['tr_technicalrequests_status_list']['capability'];
                $result['capacity'] = $app_list_strings['tr_technicalrequests_status_list']['capacity'];
                $result['credit_risk'] = $app_list_strings['tr_technicalrequests_status_list']['credit_risk'];
                $result['created_in_error'] = $app_list_strings['tr_technicalrequests_status_list']['created_in_error'];
            }
            else
            {
                $result[''] = '';
            }

            return $result;
        }

            public static function assign_opportunity_id($opportunity_id = '')
            {
                global $db;
                $result = 0;
                $opportunity_bean = BeanFactory::getBean('Opportunities');
                $opportunity_bean_list = $opportunity_bean->get_full_list('id', "opportunities.id = '{$opportunity_id}'", false, 0);
        
                if(!empty($opportunity_bean_list) && count($opportunity_bean_list) > 0){
                    $result = $opportunity_bean_list[0]->oppid_c;
                }
                else{
                    $data = $db->query("select oppid_c 
                        from opportunities_cstm
                        order by oppid_c desc
                        limit 1");
                    $rowData = $db->fetchByAssoc($data);
            
                    if($rowData != null)
                    {
                        $result = $rowData['oppid_c'];
                    }
                    
                    $result += 1;
                }
        
                return $result;
            }

            public static function tbdMarketEmailNotificationBody($opportunityBean)
            {
                global $app_list_strings, $log, $sugar_config;

                if ($opportunityBean) {
                    $recordURL = $sugar_config['site_url'] . '/index.php?module=Opportunities&action=DetailView&record=' . $opportunityBean->id;
                    $emailObj = new Email();
                    $defaults = $emailObj->getSystemDefaultEmail();
                    $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
                    
                    $body = "
                        {$customQABanner}
                        
                        <p>Hi,</p>
                        <p>Please review the below for a new market request.</p>
                        <p>Module: Opportunities <br/>
                        Opp ID #: {$opportunityBean->oppid_c} <br/>
                        Opportunity Name: {$opportunityBean->name}<br/>
                        Status: ".$app_list_strings['tr_technicalrequests_status_list'][$opportunityBean->status_c]."<br>
                        Sales Stage: {$app_list_strings['sales_stage_dom'][$opportunityBean->sales_stage]} <br/>
                        Account: {$opportunityBean->account_name} <br/>
                        Markets: {$opportunityBean->mkt_markets_opportunities_1_name}
                        </p>

                        <p>Click here to access the record: <a href='{$recordURL}'>{$recordURL}</a></p>
                        Thanks,
                        <br>
                        {$defaults['name']}
                        <br>
                    ";

                    return $body;

                }

                return '';

            }
      }

?>