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

require_once('custom/modules/RRQ_RegulatoryRequests/helpers/RRQ_RegulatoryRequestsHelper.php');
require_once('custom/modules/RRQ_RegulatoryRequests/ManageTimelyNotif.php');
require_once('custom/modules/RRWG_RRWorkingGroup/helpers/RRWorkingGroupHelper.php');

class RRQ_RegulatoryRequestsController extends SugarController
{
    public function action_get_cust_prod()
    {
        global $log;
        $result = array('success' => false, 'data' => array());
        $cust_product_id_param = isset($_POST['cust_product_id']) && !empty($_POST['cust_product_id']) ? $_POST['cust_product_id'] : '';

        if(!empty($cust_product_id_param)){
            $cust_prod_bean = BeanFactory::getBean('CI_CustomerItems', $cust_product_id_param);

            if(!empty($cust_prod_bean) && !empty($cust_prod_bean->product_number_c)){
                $result['success'] = true;

                $result['data'] = array(
                    'id' => $cust_prod_bean->id,
                    'name' => $cust_prod_bean->name,
                    'product_number_c' => $cust_prod_bean->product_number_c,
                    'version_c' => $cust_prod_bean->version_c,
                    'application_c' => $cust_prod_bean->application_c,
                    'oem_account_c' => $cust_prod_bean->account_id_c,
                    'industry_c' => $cust_prod_bean->industry_c
                );
            }
        }

        echo json_encode($result);
    }

    public function action_get_regulatory_manager(){
        global $log;
        $result = array('success' => false, 'data' => array());

        $regulatory_manager_details = RRQ_RegulatoryRequestsHelper::get_regulatory_manager();

        if($regulatory_manager_details != null){
            $result['success'] = true;
            $result['data'] = $regulatory_manager_details;
        }

        echo json_encode($result);
    }

    public function action_get_customer_products(){
        global $log, $app_list_strings;
        $result = array('success' => false, 'data' => array());
        
        $current_page_param = isset($_POST['current_page']) && !empty($_POST['current_page']) ? $_POST['current_page'] : -1;
        $start_param = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : -1;
        $length_param = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : -1;
        $iDisplayStart = isset($_GET['iDisplayStart']) && !empty($_GET['iDisplayStart']) ? $_GET['iDisplayStart'] : '';
        $account_id_param = isset($_GET['accountID']) && !empty($_GET['accountID']) ? $_GET['accountID'] : '';
        $search_account_name_param = isset($_GET['searchAccountName']) && !empty($_GET['searchAccountName']) ? $_GET['searchAccountName'] : '';
        $search_prod_num_param = isset($_GET['searchProductNum']) && !empty($_GET['searchProductNum']) ? $_GET['searchProductNum'] : '';
        $search_prod_name_param = isset($_GET['searchProductName']) && !empty($_GET['searchProductName']) ? $_GET['searchProductName'] : '';
        $search_cust_prod_num_param = isset($_GET['searchCustProdNum']) && !empty($_GET['searchCustProdNum']) ? $_GET['searchCustProdNum'] : '';
        $iTotal = 0;
        $iFilteredTotal = 0;
        $aaData = array();

        //$cust_prod_list = $customer_product_bean->get_list("", "ci_customeritems.deleted = 0", $_GET['iDisplayStart'], $_GET['iDisplayLength']);

        $display_length = $_GET['iDisplayLength'];
        $sort_column = RRQ_RegulatoryRequestsHelper::get_sort_column($_GET['iSortCol_0']);
        $sort_col_order = "{$sort_column} {$_GET['sSortDir_0']}";
        $cust_prod_list = RRQ_RegulatoryRequestsHelper::get_customer_products_data($sort_col_order, $display_length, $iDisplayStart, $account_id_param, 
            $search_account_name_param, $search_prod_num_param, $search_prod_name_param, $search_cust_prod_num_param);
        $cust_prod_count = RRQ_RegulatoryRequestsHelper::get_customer_products_data_count($sort_col_order, $account_id_param,
            $search_account_name_param, $search_prod_num_param, $search_prod_name_param, $search_cust_prod_num_param);
        $iTotalRecords = $cust_prod_count;
        $iTotalDisplayRecords = $cust_prod_count;

        $accountNameString = '';
        if (!empty($_GET['accountID'])) {
            $accountBean = BeanFactory::getBean('Accounts', $_GET['accountID']);
            $accountNameString =  $accountBean->name;
        }
        
        // $log->fatal(print_r($cust_prod_list, true));
        //$log->fatal(print_r($customer_product_bean->create_new_list_query(), true));

        if(!empty($cust_prod_list) && count($cust_prod_list) > 0){
            $result['success'] = true;
            $result['data']['count'] = count($cust_prod_list);
            

            //foreach($cust_prod_list as $cust_prod_bean){
            foreach($cust_prod_list as $cust_prod){
                $product_number_c = ($cust_prod['product_number_c'] == '**') ? '&#42;&#42;' : $cust_prod['product_number_c'];

                $row = array(
                    '0' => $cust_prod['id'],
                    '1' => $cust_prod['account_name'],
                    '2' => $product_number_c,
                    '3' => $cust_prod['name'],
                    '4' => $app_list_strings['customer_products_status_list'][$cust_prod['status']],
                    '5' => $cust_prod['application_c'],
                    '6' => $cust_prod['oem_account_c'],
                    '7' => $cust_prod['customer_product_id_number_c']
                );
                
                $aaData[] = $row;
            }

            
        }
        else{
            $result['data']['count'] = 0;
        }

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotalRecords,
            "iTotalDisplayRecords" => $iTotalDisplayRecords,
            "aaData" => $aaData,
            "accountNameString" => $accountNameString

        );

        echo json_encode($output);
    }

    public function action_retrieve_assigned_user()
    {
        global $log, $current_user;
        $result = array('success' => false, 'data' => array());
        $regulatoryID = $_GET['regulatory_id'];
        $currentStatus = $_GET['currentStatus'];
        $currentAssignedUserId = $_GET['currentAssignedUserId'];

        // Current Assigned User Bean
        $currentAssignedUserBean = BeanFactory::getBean('Users', $currentAssignedUserId);

        // Regulatory Request Bean
        $regulatoryRequestBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $regulatoryID);

        // Regulatory Manager Bean
        $regulatoryManagerUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($regulatoryRequestBean, 'RegulatoryManager');
        
        // Regulatory Analyst Bean
        $regulatoryAnalystUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($regulatoryRequestBean, 'RegulatoryAnalyst');

        // Requestor Bean
        $requestorUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($regulatoryRequestBean, 'Requestor');
        
        // Creator User Bean
        $creatorUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($regulatoryRequestBean, 'Creator');
        $creatorUserBean = ($creatorUserBean && $creatorUserBean->id) ? $creatorUserBean : $current_user;
        
        switch ($currentStatus) {
            case 'new':
                if ($regulatoryManagerUserBean && $regulatoryManagerUserBean->id) {
                    $result['success'] = true;
                    $result['data'] = array(
                        'id' => $regulatoryManagerUserBean->id,
                        'full_name' => $regulatoryManagerUserBean->full_name,
                    );
                }
                break;
            case 'assigned':
            case 'in_process':
                if ($regulatoryAnalystUserBean && $regulatoryAnalystUserBean->id) {
                    $result['success'] = true;
                    $result['data'] = array(
                        'id' => $regulatoryAnalystUserBean->id,
                        'full_name' => $regulatoryAnalystUserBean->full_name
                    );    
                } else {
                    if ($currentAssignedUserBean && $currentAssignedUserBean->id) {
                        $result['success'] = true;
                        $result['data'] = array(
                            'id' => $currentAssignedUserBean->id,
                            'full_name' => $currentAssignedUserBean->full_name
                        );
                    }
                }
                break;
            case 'complete':
            case 'rejected':
                if ($requestorUserBean && $requestorUserBean->id) {
                    $result['success'] = true;
                    $result['data'] = array(
                        'id' => $requestorUserBean->id,
                        'full_name' => $requestorUserBean->full_name
                    );
                }
                break;
            case 'waiting_on_supplier':
                if ($currentAssignedUserBean && $currentAssignedUserBean->id) {
                    $result['success'] = true;
                    $result['data'] = array(
                        'id' => $currentAssignedUserBean->id,
                        'full_name' => $currentAssignedUserBean->full_name
                    );
                }
                break;
            default:
                
                if ($creatorUserBean && $creatorUserBean->id) {
                    $result['success'] = true;
                    $result['data'] = array(
                        'id' => $creatorUserBean->id,
                        'full_name' => $creatorUserBean->full_name
                    );
                    
                } else {
                    if ($regulatoryRequestBean && $regulatoryRequestBean->id) {
                        $result['success'] = true;
                        $result['data'] = array(
                            'id' => $regulatoryRequestBean->assigned_user_id,
                            'full_name' => $regulatoryRequestBean->assigned_user_name
                        );
                    }
                }
                break;
        } // end of switch
        
        echo json_encode($result);
    }

    public function action_status_filtered()
    {
        global $log, $app_list_strings, $current_user; // $app_list_strings['status_list']
        
        $statusValue = $_GET['status'];
        $beanId = $_GET['record_id'];
        $isSubmittedDraft = $_GET['submit_for_review'];

        $options = '';
        $result = RRQ_RegulatoryRequestsHelper::filterStatusOptions($statusValue);
        
        if ($beanId == "" && !$current_user->is_admin) {
            // On Create, status should only be Draft
            $result = array_filter($app_list_strings['reg_req_statuses'], function($key) {
                return $key == 'draft';
            }, ARRAY_FILTER_USE_KEY);
        }
        
        // On Submit For Review, force dropdown to be New only
        if ($beanId != "" && $isSubmittedDraft == "true" && !$current_user->is_admin) {
            $result = array_filter($app_list_strings['reg_req_statuses'], function($key) {
                return $key == 'new';
            }, ARRAY_FILTER_USE_KEY);
        }


        foreach ($result as $key => $value) {
          
            $selected = $key == $statusValue ? 'selected' : '';
            $options .= "<option label='{$value}' value='{$key}' {$selected}>{$value}";
            $options .= "</option>";
        }
        echo $options;
    }

} // end of class

