pt<?php

require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;


class AccountProfileReportHelper 
{
    public static function getRevenueAndBudget($accountBean)
    {

        $dateNow = Carbon::now();
        $currentMonthRevenuePropName = 'cur_year_month'.$dateNow->month.'_c';
        $prevMonthRevenuePropName = 'cur_year_month'.$dateNow->subMonth()->month.'_c';

        $cccShare = 0;
        if ($accountBean->sls_ytd_c != 0) {
            $cccShare = (floatval($accountBean->annual_revenue_potential_c /  $accountBean->sls_ytd_c)) * 100;
        }

        // If Customer Parent, values are accumulated values of its child accounts
        if ($accountBean->account_type == 'CustomerParent') {

            $accountBean->ytd_budget_c = self::getRollUpBudgetAndRevenueValues($accountBean, 'accounts_cstm.ytd_budget_c');
            $accountBean->sls_ly_c = self::getRollUpBudgetAndRevenueValues($accountBean, 'accounts_cstm.sls_ly_c');
            $accountBean->sls_ytd_c = self::getRollUpBudgetAndRevenueValues($accountBean, 'accounts_cstm.sls_ytd_c');
            $accountBean->annual_revenue_potential_c = self::getRollUpBudgetAndRevenueValues($accountBean, 'accounts_cstm.annual_revenue_potential_c');
            $accountBean->{$prevMonthRevenuePropName} = self::getRollUpBudgetAndRevenueValues($accountBean, "accounts_cstm.{$prevMonthRevenuePropName}");
            $accountBean->{$currentMonthRevenuePropName} = self::getRollUpBudgetAndRevenueValues($accountBean, "accounts_cstm.{$currentMonthRevenuePropName}");
        }

        $pdfData =  array(
            'tableTitle' => 'Revenue &#38; Budget Data',
            'tableData' => array(
                // table row
                array(
                    array(
                        'label' => "Current Year Budget: ",
                        'data' => NumberHelper::GetCurrencyValue($accountBean->ytd_budget_c)
                    ), // column
                    array(
                        'label' => "Trend Line: ",
                        'data' => ""
                    ), // column
                ),
                // table row
                array(
                    array(
                        'label' => 'Revenue YTD: ', 
                        'data' => NumberHelper::GetCurrencyValue($accountBean->sls_ytd_c)
                    ), // column
                    array(
                        'label' => 'Revenue PYTD: ', 
                        'data' => NumberHelper::GetCurrencyValue($accountBean->sls_ly_c)
                    ), // column
                ),
                // table row
                array(
                    array(
                        'label' => 'Revenue MTD: ', 
                        'data' => NumberHelper::GetCurrencyValue($accountBean->{$currentMonthRevenuePropName})
                    ), // column
                    array(
                        'label' => 'Revenue PMTD: ', 
                        'data' => NumberHelper::GetCurrencyValue($accountBean->{$prevMonthRevenuePropName})
                    ), // column
                ),
                // table row
                array(
                    array(
                        'label' => 'Color Spend: ', 
                        'data' => NumberHelper::GetCurrencyValue($accountBean->annual_revenue_potential_c)
                    ), // column
                    array(
                        'label' => 'CCC\'s Share of Business%: ', 
                        'data' => $cccShare
                    ), // column
                ),
            
            )
        ); // Revenue and budget data

        return $pdfData;
    }

    public static function getAccountContacts($accountBean)
    {
        global $log, $app_list_strings;

        if ($accountBean->account_type == 'CustomerParent') {
            $contacts = self::getRollUpRelatedData($accountBean, 'contacts');
        } else {

            $accountBean->load_relationship('contacts');
            $contacts = $accountBean->contacts->getBeans();
        }


        $pdfData =  array(
            'tableTitle' => 'Key Contacts &#38; Roles',
            'tableHeader' => array(
                "Name",
                "Reports To",
                "Title",
                "Phone",
                "Type",
                "Email",
            )
        );

        if (count($contacts) > 0) {

            foreach ($contacts as $contact) {
                $pdfData['tableData'][] = array(
                    array(
                        'label' => "",
                        'data' => "{$contact->first_name} {$contact->last_name}"
                    ), // column
                    array(
                        'label' => "",
                        'data' => "{$contact->report_to_name}"
                    ), // column
                    array(
                        'label' => "",
                        'data' => $contact->title
                    ), // column
                    array(
                        'label' => "",
                        'data' => $contact->phone_work
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['contact_type_list'][$contact->type_c]
                    ), // column
                    array(
                        'label' => "",
                        'data' => $contact->emailAddress->getPrimaryAddress($contact)
                    ), // column
                );
            }
    
            return $pdfData;

        }
        return $pdfData;
        
    }
    
    public static function getAccountSalesObjectives($accountBean)
    {
        $pdfData =  array(
            'tableTitle' => 'Sales Goals &#38; Objectives',
            'tableData' => array(
                array(
                    array(
                        'label' => "",
                        'data' => ""
                    ), // column
                ),
            )
        );

        return $pdfData;
    }
    public static function getAccountChallenges($accountBean)
    {
        global $log, $app_list_strings;

        if ($accountBean->account_type == 'CustomerParent') {
            $challenges = self::getRollUpRelatedData($accountBean, 'accounts_chl_challenges_1');
        } else {
            // accounts_chl_challenges_1
            $accountBean->load_relationship('accounts_chl_challenges_1');
            $challenges = $accountBean->accounts_chl_challenges_1->getBeans();
        }
       

        $pdfData =  array(
            'tableTitle' => 'Challenges',
            'tableHeader' => array(
                "Name",
                "Related To",
                "Type",
                "Status",
                "$ Value if Solved",
            ),
        );

        if (count($challenges) > 0) {
            foreach ($challenges as $challenge) {
                $pdfData['tableData'][] = array(
                    array(
                        'label' => "",
                        'data' => $challenge->name
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['chl_related_to'][$challenge->related_to_c]
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['chl_type_list'][$challenge->type_c]
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['chl_status'][$challenge->status_c]
                    ), // column
                    array(
                        'label' => "",
                        'data' => NumberHelper::GetCurrencyValue($challenge->value_c)
                    ), // column
                );
            }
        }

        return $pdfData;
    }
    
    public static function getAccountCustomerIssues($accountBean)
    {
        global $log, $app_list_strings;
        if ($accountBean->account_type == 'CustomerParent') {
            $cases = self::getRollUpRelatedData($accountBean, 'cases');
        } else {
            $accountBean->load_relationship('cases');
            $cases = $accountBean->cases->getBeans();
        }

        
        
        $pdfData =  array(
            'tableTitle' => 'Customer Issues',
            'tableHeader' => array(
                "Issue #",
                "Customer Issue",
                "Status",
                "Priority",
                "Contact",
                "Dept",
                "Site",
                "Date Created",
            ),
            'tableData'=> array()
        );

        if (count($cases) > 0) {
            
            foreach ($cases as $index => $customerIssue) {
                
                // row
                $pdfData['tableData'][$index][] = array(
                    array(
                        'label' => "",
                        'data' => $customerIssue->case_number
                    ), // column
                    array(
                        'label' => "",
                        'data' => $customerIssue->name
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['status_list'][$customerIssue->status]
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['ci_severity_list'][$customerIssue->priority]
                    ), // column
                    array(
                        'label' => "",
                        'data' => $customerIssue->contact_created_by_name
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['ci_department_list'][$customerIssue->ci_department_c]
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['site_list'][$customerIssue->site_c]
                    ), // column
                    array(
                        'label' => "",
                        'data' => Carbon::parse($customerIssue->date_entered)->format('m/d/Y')
                    ), // column
                );

                $customColumn = "
                    <b>Root Cause Type:</b><br>
                    {$app_list_strings['root_cause_type_list'][$customerIssue->root_cause_type_c]}<br>
                ";
                $customColumn .= "
                    <b>Potential Claim:</b><br>
                    {$app_list_strings['potential_claim_list'][$customerIssue->potential_claim_c]}<br>
                ";
                $customColumn .= "
                    <b>Potential Return:</b><br>
                    {$app_list_strings['potential_claim_list'][$customerIssue->potential_claim_c]}
                ";
                // Row
                $pdfData['tableData'][$index][] = array(
                    array(
                        'class' => '',
                        'colspan' => 2,
                        'label' => "",
                        'data' => "<span style=\"font-size:10px;\">{$customColumn}</span>"
                    ), // column
                    array(
                        'class' => '',
                        'colspan' => count($pdfData['tableHeader']) - 2,
                        'label' => "<span style=\"font-size:10px;\"><b>Root Cause:</b></span><br>",
                        'data' => "<span style=\"font-size:10px;\">{$customerIssue->root_cause_c}</span>"
                    ), // column
                    
                );
                
            }
            
            return $pdfData;
        }

        return $pdfData;

    }
    
    public static function getAccountOpportunities($accountBean)
    {
        global $log, $app_list_strings;

        if ($accountBean->account_type == 'CustomerParent') {
            
            $opportunities = self::getRollUpRelatedData($accountBean, 'opportunities'); // roll up data
        } else {

            $accountBean->load_relationship('opportunities');
            $opportunities = $accountBean->opportunities->getBeans();
        }
        

        $pdfData =  array(
            'tableTitle' => 'Opportunities',
            'tableHeader' => array(
                "Opp ID #",
                "Type",
                "Name",
                "Contact",
                "Sales Stage",
                "Status",
                "Exp. Close",
                "Amount",
                "Annual Volume"
            )
        );

        if (count($opportunities) > 0) {
            foreach ($opportunities as $opportunity) {
                
                $closedStageValues = ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'];
                $expCloseDate = (in_array($opportunity->sales_stage, $closedStageValues)) 
                    ? $opportunity->closed_date_c 
                    : $opportunity->date_closed;

                $pdfData['tableData'][] = array(
                    array(
                        'label' => "",
                        'data' => $opportunity->oppid_c
                    ), // column
                    array(
                        'label' => "",
                        'data' => $opportunity->opportunity_type
                    ), // column
                    array(
                        'label' => "",
                        'data' => $opportunity->name
                    ), // column
                    array(
                        'label' => "",
                        'data' => $opportunity->contact_c
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['sales_stage_dom'][$opportunity->sales_stage]
                    ), // column
                    array(
                        'label' => "",
                        'data' => $app_list_strings['tr_technicalrequests_status_list'][$opportunity->status_c]
                    ), // column
                    array(
                        'label' => "",
                        'data' => Carbon::parse($expCloseDate)->format('m/d/Y')
                    ), // column
                    array(
                        'label' => "",
                        'data' => NumberHelper::GetCurrencyValue($opportunity->amount)
                    ), // column
                    array(
                        'label' => "",
                        'data' => $opportunity->annual_volume_lbs_c
                    ), // column
                );
            }
        }

        return $pdfData;
    }

    public static function getChildAccountLocations($accountBean)
    {
        global $log, $app_list_strings;
        $pdfData = [];

        if ($accountBean->account_type == 'CustomerParent') {

            $accountBean->load_relationship('members');
            $childAccounts = $accountBean->members->getBeans();

            $pdfData =  array(
                'tableTitle' => 'Locations',
                'tableData' => array()
            );

            if (count($childAccounts) > 0) {

                $columns = 1;
                $row = 0;
                foreach ($childAccounts as $key => $childAccount) {
                    $dataStr = '<table border="0">';

                    $dataStr .= '<tr>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Customer #: </span>'.$childAccount->cust_num_c.'</td>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Customer Name: </span>'.$childAccount->name.'</td>';
                    $dataStr .= '</tr>';
                    
                    $dataStr .= '<tr>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Validated Address: </span>';
                    $dataStr .= $childAccount->billing_address_country . '<br>';
                    $dataStr .= $childAccount->billing_address_street . ' ';
                    $dataStr .= $childAccount->billing_address_city . ' ';
                    $dataStr .= $childAccount->billing_address_state . ' ';
                    $dataStr .= $childAccount->billing_address_postalcode;
                    $dataStr .= '</td>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Shipping Address: </span>';
                    $dataStr .= $childAccount->shipping_address_country . '<br>';
                    $dataStr .= $childAccount->shipping_address_street . ' ';
                    $dataStr .= $childAccount->shipping_address_city . ' ';
                    $dataStr .= $childAccount->shipping_address_state . ' ';
                    $dataStr .= $childAccount->shipping_address_postalcode;
                    $dataStr .= '</td>';
                    $dataStr .= '</tr>';

                    $dataStr .= '<tr>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Main Contact: </span>'.$childAccount->assigned_user_name.'</td>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Phone #: </span>'.$childAccount->phone_office.'</td>';
                    $dataStr .= '</tr>';
                    
                    $dataStr .= '<tr>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Current Sales YTD: </span>'.NumberHelper::GetCurrencyValue($childAccount->sls_ytd_c).'</td>';
                    $dataStr .= '<td class="custom-inline" style="text-align: left; word-wrap: break-word"><span class="inline-label">Sales LYTD: </span>'.NumberHelper::GetCurrencyValue($childAccount->sls_ly_c).'</td>';
                    $dataStr .= '</tr>';
                    
                    $dataStr .= '</table>';
                    

                    if (count($pdfData['tableData']) == 0) {
                        $pdfData['tableData'][] = [
                            array(
    
                                'label' => '',
                                'data' => $dataStr
                            )
                        ];
                    } /* else if (count($pdfData['tableData'][$row]) != 2) {
                        $pdfData['tableData'][$row][] =  array(
    
                            'label' => '',
                            'data' => $dataStr
                        );
                    }*/ else {
                        $row++;
                        $pdfData['tableData'][$row][] =  array(
    
                            'label' => '',
                            'data' => $dataStr
                        );
                    }
                    
                }

                
            }
        }
        
        return $pdfData;
    }

    public static function getAccountCompetitors($accountBean)
    {
        global $log, $app_list_strings;
        if ($accountBean->account_type == 'CustomerParent') {
            $competitors = self::getRollUpRelatedData($accountBean, 'accounts_comp_competitor_1');
        } else {
            $accountBean->load_relationship('accounts_comp_competitor_1');
            $competitors = $accountBean->accounts_comp_competitor_1->getBeans();
        }

        $pdfData =  array(
            'tableTitle' => 'Competitors',
            'tableHeader' => array(
                "Name",
                "Sales Position",
                "% of Business",
            ),
        );

        if (count($competitors) > 0) {


            foreach ($competitors as $index => $competitor) {
                $pdfData['tableData'][] = array(
                    array(
                        'label' => "",
                        'data' => $competitor->name
                    ), // column
                    array(
                        'label' => "",
                        'data' => $competitor->sales_position
                    ), // column
                    array(
                        'label' => "",
                        'data' => $competitor->percent_of_business
                    ), // column
                );
            }
    
            return $pdfData;
        }

        return $pdfData;
    }

    private static function getRollUpRelatedData($accountBean, $relationship_name = '')
    {
        global $log;

        $rollUpDataArray = array(); // Array of beans

        $bean = BeanFactory::getBean('Accounts');

        $beanList = $accountBean->get_full_list(
            '', 
            "accounts.id = '{$accountBean->id}' OR accounts.parent_id = '{$accountBean->id}' ");
        
        foreach ($beanList as $account) {
            $account->load_relationship($relationship_name);
            $rollupData = $account->{$relationship_name}->getBeans();
            
            foreach ($rollupData as $data) {
                $rollUpDataArray[] = $data;
            }
        }
        
        return $rollUpDataArray;
        
    }

    private static function getRollUpBudgetAndRevenueValues($accountBean, $columnName = '')
    {
        global $db, $log;

        
        $query = "
            SELECT 
                    SUM({$columnName}) as field_value
                FROM
                    accounts
                        LEFT JOIN
                    accounts_cstm ON accounts_cstm.id_c = accounts.id
                        AND accounts.deleted = 0
                WHERE
                    accounts.parent_id = '{$accountBean->id}'
            ";
        
        $result = $db->query($query);
        $data = $db->fetchByAssoc($result);
        
        $returnData = $data ? $data['field_value'] : 0;

        return $returnData;
        
    }

} // End of class