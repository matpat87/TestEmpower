<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

class OpportunitiesController extends SugarController
{
    public function action_get_status_dropdown()
    {
        global $log;
        $result = array('success' => true, 'data' => array('options' => array(), 'default_option' => ''));
        $stageParam = '';
        $opportunity_id = (!empty($_POST['opportunity_id'])) ? $_POST['opportunity_id'] : ''; 

        if($_POST != null && !empty($_POST['stage']))
        {
            $stageParam = $_POST['stage'];
            
            $result['data']['options'] = OpportunitiesHelper::get_status($stageParam);

            if($opportunity_id != '')
            {
                $opportunity_bean = BeanFactory::getBean('Opportunities', $opportunity_id);

                if($opportunity_bean != null && $opportunity_bean->sales_stage == $stageParam )
                {
                    $result['data']['default_option'] = $opportunity_bean->status_c;
                }
            }
        }
        
        echo json_encode($result);
    }

    public function action_get_trs()
    {
        global $log;
        $result = array('success' => false, 'data' => array('opportunity' => array(), 'trs_count' => 0));
        $opportunity_id_param = '';

        if($_POST != null && !empty($_POST['opportunity_id']))
        {
            $opportunity_id_param = $_POST['opportunity_id'];
            $source_opportunity_bean = BeanFactory::getBean('Opportunities', $opportunity_id_param);

            if($source_opportunity_bean != null){
                $source_opportunity_bean->load_relationship('tr_technicalrequests_opportunities');
                $tr_beans = $source_opportunity_bean->tr_technicalrequests_opportunities->getBeans();
                $tr_beans_count = count($tr_beans);

                //$date = new DateTime($source_opportunity_bean->date_modified);
                //$date_modified = $date->format('Y-m-d H:i:s');
                $opportunity_db_details = TechnicalRequestHelper::get_opportunity_details($opportunity_id_param);
                

                $result['data']['opportunity'] = array(
                    'id' => $source_opportunity_bean->id,
                    'annual_volume_lbs_c' => $source_opportunity_bean->annual_volume_lbs_c,
                    'avg_sell_price_c' => '$' . number_format($source_opportunity_bean->avg_sell_price_c, 2, '.', ','),
                    'amount' => '$' . number_format($source_opportunity_bean->amount, 2, '.', ','),
                    'date_modified' => $opportunity_db_details['date_modified'],
                    'probability_prcnt_c' => $source_opportunity_bean->probability_prcnt_c,
                    'sales_stage' => $source_opportunity_bean->sales_stage
                );
                $result['data']['trs_count'] = $tr_beans_count;

            }

            $result['success'] = true;
        }
        
        echo json_encode($result);
    }

    public function action_get_oem()
    {
        global $log;
        $result = array('data' => array(), 'status' => false);
        $accountId = $_POST['account_id'];

        if (! empty($accountId)) {
            $accountBean = BeanFactory::getBean('Accounts', $accountId);
            
            if ($accountBean->account_type == 'Customer' && $accountBean->oem_c == 'Yes') {
                $parentAccountBean = BeanFactory::getBean('Accounts', $accountBean->parent_id);

                $result['data']['oem_account_id'] = $parentAccountBean->id;
                $result['data']['oem_account_name'] = $parentAccountBean->name;
            } else if ($accountBean->account_type == 'CustomerParent' && $accountBean->oem_c == 'Yes') {
                $result['data']['oem_account_id'] = $accountBean->id;
                $result['data']['oem_account_name'] = $accountBean->name;
            } else {
                $unknownAccountBean = BeanFactory::getBean('Accounts')->retrieve_by_string_fields(
                    array(
                        'name' => 'Unknown OEM',
                        'account_type' => 'OEMBrandOwner',
                        'oem_c' => 'Yes',
                    ), false, true
                );

                // If Unknown OEM does not exist for account type OEM Brand Owner, look for Unknown OEM with account type Customer Parent instead with OEM set to Yes
                $unknownAccountBean = $unknownAccountBean->id ? $unknownAccountBean : BeanFactory::getBean('Accounts')->retrieve_by_string_fields(
                    array(
                        'name' => 'Unknown OEM',
                        'account_type' => 'CustomerParent',
                        'oem_c' => 'Yes',
                    ), false, true
                );

                $result['data']['oem_account_id'] = $unknownAccountBean->id;
                $result['data']['oem_account_name'] = $unknownAccountBean->name;
            }
        }

        echo json_encode($result);
    }

    public function action_check_if_tr_exists()
    {
        $result = array('data' => array(), 'success' => false);
        $oppId = $_POST['opportunity_id'];
        $result['data']['tr_exists'] = false;
        
        if(! empty($oppId)) {
            $opportunityBean = BeanFactory::getBean('Opportunities', $oppId);
            
            if ($opportunityBean && $opportunityBean->id) {
                $opportunityBean->load_relationship('tr_technicalrequests_opportunities');
                $trBeans = $opportunityBean->tr_technicalrequests_opportunities->getBeans();
                $result['data']['tr_exists'] = count($trBeans) > 0 ? true : false ;
                $result['success'] = true;
            }
        }

        echo json_encode($result);
    }


    // Retrieves Sub Industry values via Ajax request
    public function action_get_sub_industry_dropdown()
    {
        global $log, $db;
        $oppId = $_GET['opportunity_id'];
        
        $subIndustries = get_sub_industry($_GET['industry']);

        if (isset($oppId)) {
            $opportunity = BeanFactory::getBean('Opportunities', $oppId);
            $subIndustry = $opportunity->sub_industry_c ?? '';
        }

        $result = array(
            'current_value' => ($subIndustry) ? $subIndustry : '',
            'dropdown_list' => $subIndustries
         );

        echo json_encode($result);
    }
    // Retrieves Sub Industry values via Ajax request
    public function action_get_industry_dropdown()
    {
        global $log, $db, $app_list_strings;
        
        $oppId = $_GET['opportunity_id'];
        $subIndustry = $_GET['sub_industry'];
        $subIndustries = get_sub_industry_dropdown($_GET['industry']);
        $filterStr = '';
        
        if (isset($oppId)) {
            $opportunity = BeanFactory::getBean('Opportunities', $oppId);
            $industry = $opportunity->sub_industry_c ?? ''; // set the selected value to the Industry ID instead of the industry_dom value
        } else {
            // Case: Advanced filter where there is no Specific OPP ID to query for industry value
            $industry = $_GET['industry'];
        }

        if (isset($subIndustry) && !is_array($subIndustry) && $subIndustry != '') {
            $filterStr = " AND mkt_markets_cstm.sub_industry_c = '{$subIndustry}'";
        } elseif (is_array($subIndustry) && count($subIndustry) > 0) {
            $ids = implode("','", $subIndustry);
            $filterStr = " AND mkt_markets_cstm.sub_industry_c IN ('{$ids}') ";
        } else {
            $filterStr = "";
        }

        $industryBean = BeanFactory::getBean('MKT_Markets');
        $industryBeanList = $industryBean->get_full_list(
            'name',
            "mkt_markets.id IS NOT NULL {$filterStr}"
            );
        
        // If ajax triggered from advanced filter form, should return the original industry_dom key => value pair
        if (!isset($_REQUEST['advanced_filter_form'])) {
            $filteredIndustryDom = array_map(function($industryItem) use ($app_list_strings){
                return $app_list_strings['industry_dom'][$industryItem];
            }, array_column($industryBeanList, 'name', 'id'));

        } else {
            $filteredIndustryDom = array_filter($app_list_strings['industry_dom'], function($val, $key) use ($industryBeanList) {
                return in_array($key, array_column($industryBeanList, 'name'));
            }, ARRAY_FILTER_USE_BOTH);
        }

        
        $filteredIndustryDom = array('' => '' ) + array_unique($filteredIndustryDom); // blank option at the beginning of an array

        $result = array(
            'current_value' => ($industry) ? $industry : null,
            'dropdown_list' => ($filterStr != '') ? $filteredIndustryDom: [],
         );

        echo json_encode($result);
    }

    public function action_retrieve_related_account_account_priority()
    {
        global $log, $db, $app_list_strings;
        $oppId = $_GET['opp_id'];
        $result = ['success' => false, 'opp_rel_account' => null];

        $opportunityBean = BeanFactory::getBean('Opportunities', $oppId);
        $opportunityBean->load_relationship('accounts');
        $relAccountBeanArr = $opportunityBean->accounts->getBeans();
        
        if (count($relAccountBeanArr) > 0) {

            $result['success'] = true;
            $result['opp_rel_account'] = [
                'id' => $relAccountBeanArr[$opportunityBean->account_id]->id,
                'account_priority' => $relAccountBeanArr[$opportunityBean->account_id]->account_class_c
            ];
        }
        
        
        echo json_encode($result);
    }
}