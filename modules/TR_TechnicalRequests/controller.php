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
require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');

class TR_TechnicalRequestsController extends SugarController
{
    public function action_get_status_dropdown()
    {
        global $log;
        $result = array('success' => true, 'data' => array());
        $stageParam = '';

        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['id']);
        $currentStage = ($trBean && $trBean->id) ? $trBean->approval_stage : 'understanding_requirements';
        $currentStatus = ($trBean && $trBean->id) ? $trBean->status : 'in_process';
        $isSubmitToDev = (isset($_POST['is_submit_for_development']) && $_POST['is_submit_for_development'] == 'true') ? true : false;
        $isByPass = (isset($_POST['is_by_pass']) && $_POST['is_by_pass'] == 'true') ? true : false;

        if($_POST != null && !empty($_POST['stage']))
        {
            $stageParam = $_POST['stage'];
            $statusData = array();

            if(is_array($stageParam)){
                foreach($stageParam as $stageVal){
                    $stageList = TechnicalRequestHelper::get_status($stageVal, $currentStage, $currentStatus, $isSubmitToDev, $isByPass);
                    foreach($stageList as $stageKey => $stageItem){
                        $statusArr = array('key' => $stageKey, 'val' => $stageItem);
                        array_push($statusData, $statusArr);
                    }

                    array_sort_by_column($statusData, 'val');
                }
            }
            else{
                $statusData = TechnicalRequestHelper::get_status($stageParam, $currentStage, $currentStatus, $isSubmitToDev, $isByPass);
            }
            
            $result['data'] = $statusData;
        }
        
        echo json_encode($result);
    }

    public function action_get_opportunity()
    {
        global $log;
        $result = array(
            'success' => true, 
            'data' => array(
                'opportunity' => array(
                    'market_c' => '', 'mkt_markets_id_c' => '', 'tr_technicalrequests_accounts_name' => '', 'tr_technicalrequests_accountsaccounts_ida' => '', 'contact_c' => '', 'contact_id1_c' => ''
                )
            )
        );

        $stage_id_param = '';

        if($_POST != null && !empty($_POST['opportunity_id']) && !empty($_POST['stage_id']))
        {
            $stage_id_param = $_POST['stage_id'];
            $probability_percentage = TechnicalRequestHelper::get_tr_probability_percentage($stage_id_param);

            $result['success'] = true;
            $result['data']['probability_percentage'] = ($probability_percentage > 0) ? $probability_percentage : 0;

            //For Opportunity
            $opportunity_bean = BeanFactory::getBean('Opportunities', $_REQUEST['opportunity_id']);
            $opportunity_bean->load_relationship('mkt_markets_opportunities_1');
            $opp_markets = $opportunity_bean->mkt_markets_opportunities_1->getBeans();
            if(count($opp_markets) > 0)
            {
                $market = reset($opp_markets);
                $result['data']['opportunity']['market_c'] = $market->name;
                $result['data']['opportunity']['mkt_markets_id_c'] = $market->id;
            }

            if ($opportunity_bean->account_id) {
                $accountBean = BeanFactory::getBean('Accounts', $opportunity_bean->account_id);
                
                if ($accountBean) {
                    $result['data']['opportunity']['tr_technicalrequests_accounts_name'] = $accountBean->name;
                    $result['data']['opportunity']['tr_technicalrequests_accountsaccounts_ida'] = $accountBean->id;
                }
            }

            if ($opportunity_bean->contact_id_c) {
                $contactBean = BeanFactory::getBean('Contacts', $opportunity_bean->contact_id_c);
                
                if ($contactBean) {
                    $result['data']['opportunity']['contact_c'] = $contactBean->name;
                    $result['data']['opportunity']['contact_id1_c'] = $contactBean->id;
                }
            }
        }
        
        echo json_encode($result);
    }

    public function action_get_technicalrequests_by_opportunity()
    {
        global $log;
        $result = array('success' => true, 'data' => array('tr_list' => array(), 'count' => 0));
        $stageParam = '';
        $opp_id = isset($_POST['opportunity_id']) ? $_POST['opportunity_id'] : '';

        if(!empty($opp_id))
        {
            $result['data']['tr_list'] = TechnicalRequestHelper::get_opp_trs_with_distros($opp_id);
            $result['data']['count'] = count($result['data']['tr_list']);
        }
        
        echo json_encode($result);
    }

    public function action_get_distribution_list()
    {
        global $log, $app_list_strings;
        $result = array('success' => true, 'data' => array('distribution_list' => array()));
        $stageParam = '';
        $tr_id = isset($_POST['tr_id']) ? $_POST['tr_id'] : '';

        if ($tr_id) {
            $tr_bean = BeanFactory::getBean('TR_TechnicalRequests', $tr_id);

            if (!empty($tr_bean->id)) {                
                $distroBean = BeanFactory::getBean('DSBTN_Distribution');
                $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$tr_bean->id}'", false, 0);

                if (isset($distroBeanList)) {
                    $distribution_list = array();

                    foreach($distroBeanList as $distroBean) {
                        $contact_bean = BeanFactory::getBean('Contacts', $distroBean->contact_id_c);
                        $account_bean = BeanFactory::getBean('Accounts', $distroBean->account_id_c);
                        $distribution_item_bean = BeanFactory::getBean('DSBTN_DistributionItems');
                        $distro_items = $distribution_item_bean->get_list('name', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}'");
                        
                        $distribution_list = array();
                        $distribution_list['header'] = 'TR# ' . $tr_bean->technicalrequests_number_c . '.' . $tr_bean->version_c . ' (' . $tr_bean->name . ')';
                        $distribution_list['column_headers'] = ['Distro Item', 'Quantity', 'Delivery Method'];

                        foreach($distro_items['list'] as $distro_item) {
                            $distribution_item_c = DistributionHelper::GetDistributionItemLabel($distro_item->distribution_item_c);
                            $city = $distroBean->alt_address_city;
                            $state = $distroBean->alt_address_state;
                            if ($distroBean->ship_to_address_c == 'primary_address') {
                                $city = $distroBean->primary_address_city;
                                $state = $distroBean->primary_address_state;
                            }

                            if (!empty($state)) {
                                $state = $app_list_strings['states_list'][$state];
                            }

                            $distribution_list['data'][] = array(
                                'contact_name' => "{$contact_bean->first_name} {$contact_bean->last_name}" ?? 'No Contact',
                                'account_name' => $account_bean->name, 
                                'distribution_item' => $distro_item->distribution_item_c,
                                'qty' => $distro_item->qty_c,
                                'shipping_method' => $distro_item->shipping_method_c,
                            );
                        }

                        $result['data']['distribution_list'][] = $distribution_list;
                    }

                    
                }
            }
        }
        
        echo json_encode($result);
    }

    public function action_check_if_sds_document_exists()
    {
        global $db;

        $response = array('success' => true, 'data' => []);
        $recordId = isset($_POST['record_id']) ? $_POST['record_id'] : '';
        $response['data'] = false;
        
        $bean = BeanFactory::getBean('TR_TechnicalRequests', $recordId);
        $bean->load_relationship('tr_technicalrequests_documents');
        $beanDocumentIdsArray = $bean->tr_technicalrequests_documents->get();
        
        if ($beanDocumentIdsArray) {
            $whereInDocumentIds = formatDataArrayForWhereInQuery(implode(',', $beanDocumentIdsArray));

            $query = "SELECT count(*)
                        FROM documents 
                        WHERE documents.id IN ({$whereInDocumentIds}) 
                        AND documents.document_name LIKE '%Safety Data Sheet%' 
                        AND documents.deleted = 0";

            $result = $db->getOne($query);
            $response['data'] = ($result) ? true : false;
        }

        echo json_encode($response);
    }

    public function action_check_if_tds_document_exists()
    {
        global $db;

        $response = array('success' => true, 'data' => []);
        $recordId = isset($_POST['record_id']) ? $_POST['record_id'] : '';
        $response['data'] = false;
        
        $bean = BeanFactory::getBean('TR_TechnicalRequests', $recordId);
        $bean->load_relationship('tr_technicalrequests_documents');
        $beanDocumentIdsArray = $bean->tr_technicalrequests_documents->get();
        
        if ($beanDocumentIdsArray) {
            $whereInDocumentIds = formatDataArrayForWhereInQuery(implode(',', $beanDocumentIdsArray));

            $query = "SELECT count(*)
                        FROM documents 
                        WHERE documents.id IN ({$whereInDocumentIds}) 
                        AND documents.document_name LIKE '%Technical Data Sheet%' 
                        AND documents.deleted = 0";

            $result = $db->getOne($query);
            $response['data'] = ($result) ? true : false;
        }

        echo json_encode($response);
    }

    public function action_get_resin_dropdown_options()
    {
        global $app_list_strings;
        asort($app_list_strings['resin_type_list']);

        $response = array('success' => true, 'data' => array());
        $resinOptions = "";

        foreach ($app_list_strings['resin_type_list'] as $key => $value) {
            if ($key === '') $value = 'Select Carrier Resin';
            $resinOptions .= "<option value='{$key}'>{$value}</option>";
        }

        $response['data']['resin_options'] = $resinOptions;
        echo json_encode($response);
    }

    public function action_check_if_colormatcher_exists()
    {
        $response = array('success' => true, 'data' => []);
        $recordId = isset($_POST['recordId']) ? $_POST['recordId'] : '';
        $response['data'] = false;

        $bean = BeanFactory::getBean('TR_TechnicalRequests', $recordId);
        $bean->load_relationship('tr_technicalrequests_aos_products_2');
        
        $workGroupColorMatcherList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatcher' AND trwg_trworkinggroup.parent_type = 'Users'");
        $colorMatcherBean = (!empty($workGroupColorMatcherList) && count($workGroupColorMatcherList) > 0) ? BeanFactory::getBean('Users', $workGroupColorMatcherList[0]->parent_id) : null;

        $response['data'] = ($colorMatcherBean && $colorMatcherBean->id) ? true : false;

        echo json_encode($response);
    }

    public function action_check_if_product_master_exists()
    {
        $response = array('success' => true, 'data' => []);
        $recordId = isset($_POST['recordId']) ? $_POST['recordId'] : '';
        $response['data'] = false;

        $bean = BeanFactory::getBean('TR_TechnicalRequests', $recordId);
        $bean->load_relationship('tr_technicalrequests_aos_products_2');

        $productMasterIds = $bean->tr_technicalrequests_aos_products_2->get();
        $response['data'] = (count($productMasterIds) > 0) ? true : false;

        echo json_encode($response);
    }
    
    public function action_check_if_pm_and_colormatcher_exists()
    {
        $response = array('success' => true, 'data' => []);
        $recordId = isset($_POST['recordId']) ? $_POST['recordId'] : '';
        $response['data'] = [
            'pm_exists' => false,
            'colormatcher_exists' => false,
        ];
        
        $bean = BeanFactory::getBean('TR_TechnicalRequests', $recordId);
        $bean->load_relationship('tr_technicalrequests_aos_products_2');

        $productMasterIds = $bean->tr_technicalrequests_aos_products_2->get();
        $response['data']['pm_exists'] = (count($productMasterIds) > 0) ? true : false;

        $workGroupColorMatcherList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatcher' AND trwg_trworkinggroup.parent_type = 'Users'");
        $colorMatcherBean = (!empty($workGroupColorMatcherList) && count($workGroupColorMatcherList) > 0) ? BeanFactory::getBean('Users', $workGroupColorMatcherList[0]->parent_id) : null;
        
        $response['data']['colormatcher_exists'] = ($colorMatcherBean && $colorMatcherBean->id) ? true : false;

        echo json_encode($response);
    }

    public function action_check_if_distro_exists()
    {
        $response = array('success' => true, 'data' => []);
        $trId = isset($_POST['recordId']) ? $_POST['recordId'] : '';
        $response['data'] = false;

        $distroBean = BeanFactory::getBean('DSBTN_Distribution');
        $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trId}'", false, 0);

        $response['data'] = ($distroBeanList) ? true : false;

        echo json_encode($response);
    }

    public function action_check_if_distro_and_tr_lab_items_completed()
    {
        $response = array('success' => true, 'data' => []);
        $recordId = isset($_POST['recordId']) ? $_POST['recordId'] : '';
        $response['data'] = [
            'status' => 'new',
            'incomplete_distro_lab_items' => [],
            'incomplete_tr_lab_items' => [],
        ];
        
        $bean = BeanFactory::getBean('TR_TechnicalRequests', $recordId);
        
        // Distro Items
        $distroBean = BeanFactory::getBean('DSBTN_Distribution');
        $distroBeanList = $distroBean->get_full_list('', "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$bean->id}'", false, 0);
        $distroItemsLabItemsList = DistributionHelper::$distro_items['Lab Items'];

        if ($distroBeanList != null && count($distroBeanList) > 0) {
            foreach ($distroBeanList as $distroBean) {
                $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                $distroItemBeanList = $distroItemBean->get_full_list('dsbtn_distributionitems_cstm.distribution_item_c', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}'", false, 0);

                if ($distroItemBeanList != null && count($distroItemBeanList) > 0) {
                    foreach ($distroItemBeanList as $distroItemkey => $distroItemBean) {
                        if (in_array($distroItemBean->distribution_item_c, array_column($distroItemsLabItemsList, 'value'))) {
                            if (! in_array($distroItemBean->status_c, ['complete', 'rejected'])) {
                                $response['data']['incomplete_distro_lab_items'][] = DistributionHelper::GetDistributionItemLabel($distroItemBean->distribution_item_c);
                            }
                        }
                    }
                }
            }
        }

        // TR Items
        $technicalRequestItemBeanList = $bean->get_linked_beans(
            'tri_technicalrequestitems_tr_technicalrequests',
            'TR_TechnicalRequests',
            array(),
            0,
            -1,
            0,
            "tri_technicalrequestitems_tr_technicalrequests_c.tri_techni0387equests_ida = '{$bean->id}'"
        );

        if($technicalRequestItemBeanList != null && count($technicalRequestItemBeanList) > 0) {
            foreach ($technicalRequestItemBeanList as $technicalRequestItemBean) {
                if (in_array($technicalRequestItemBean->name, array_column($distroItemsLabItemsList, 'value'))) {
                    if (! in_array($technicalRequestItemBean->status, ['complete', 'rejected'])) {
                        $response['data']['incomplete_tr_lab_items'][] = DistributionHelper::GetDistributionItemLabel($technicalRequestItemBean->name);
                    }
                }
            }
        }

        $response['data']['status'] = $bean->status;

        echo json_encode($response);
    }

    public function action_check_tr_product_master()
    {
        global $log;

        $response = array('success' => false, 'data' => []);
        $trID = $_GET['record_id'];

        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trID);
        $trBean->load_relationship('tr_technicalrequests_aos_products_2');

        $trProductMaster = $trBean->tr_technicalrequests_aos_products_2->get();
        $response['data'] = $trProductMaster;
        $response['success'] = (is_array($trProductMaster) && count($trProductMaster) > 0);
        // $log->fatal(print_r($response, true));
        echo json_encode($response);
    }

    public function action_get_technicalrequest_type_dropdown_list_by_opportunity()
    {
        global $app_list_strings, $log;

        $response = array('data' => []);

        $typeOptions = "";

        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $_GET['record_id']);
        $opportunityBean = BeanFactory::getBean('Opportunities', $_GET['opportunity_id']);

        $acceptedOpportunityTypes = [
            'New Customer / Current Business', 
            'Current Customer / Current Business', 
            'Current Customer / Previous Business', 
            'Previous Customer / Previous Business'
        ];

        if ((! $opportunityBean->id) || (! in_array($opportunityBean->opportunity_type, $acceptedOpportunityTypes))) {
            $trTypesToUnset = ['lab_items'];
            
            foreach($trTypesToUnset as $key => $value) {
                // Do not unset if it is currently the TR Type value
                if ($trBean->type == $value) {
                    continue;
                }

                unset($app_list_strings['tr_technicalrequests_type_dom'][$value]);
            }
        }

        foreach ($app_list_strings['tr_technicalrequests_type_dom'] as $key => $value) {
            if ($trBean->type == $key) {
                $typeOptions .= "<option value='{$key}' selected>{$value}</option>";
            } else {
                $typeOptions .= "<option value='{$key}'>{$value}</option>";
            }
        }

        $response['data']['type_value'] = $trBean->type ?? '';
        $response['data']['type_options'] = $typeOptions;
        
        echo json_encode($response);
    }

    public function action_check_tr_item_colormatch_status()
    {
        global $current_user;

        $trId = $_GET['record_id'];

        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trId);

        $colormatchTri = $trBean->get_linked_beans(
            'tri_technicalrequestitems_tr_technicalrequests',
            'TRI_TechnicalRequestItems',
            array(), 0, -1, 0,
            "tri_technicalrequestitems.name = 'colormatch_task'"
        );

        $response = array();
        $response['data']['tr_bean'] = array(
            'stage' => $trBean->approval_stage,
            'status' => $trBean->status
        );

        $response['data']['is_admin'] = $current_user->is_admin;

        if (!empty($colormatchTri)) {
            $completeColorMatch = array_filter($colormatchTri, function ($item) {
                return $item->status == 'complete';
            });

            $response['data']['has_colormatch'] = true;
            $response['data']['is_complete'] = !empty($completeColorMatch);

        } else {
            $response['data']['has_colormatch'] = false;
            $response['data']['is_complete'] = false;
        }

        echo json_encode($response);
    }
}	

