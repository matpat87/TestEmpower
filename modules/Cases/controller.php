<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
// APX Custom Codes -- START
require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');
// APX Custom Codes -- END

#[\AllowDynamicProperties]
class CasesController extends SugarController
{
    public function action_get_kb_articles()
    {
        global $mod_strings;
        global $app_list_strings;
        $search = trim($_POST['search']);

        $relevanceCalculation = "CASE WHEN name LIKE '$search' THEN 10 
                                ELSE 0 END + CASE WHEN name LIKE '%$search%' THEN 5 
                                ELSE 0 END + CASE WHEN description LIKE '%$search%' THEN 2 ELSE 0 END";

        $query = "SELECT id, $relevanceCalculation AS relevance FROM aok_knowledgebase 
                  WHERE deleted = '0' AND $relevanceCalculation > 0 ORDER BY relevance DESC";

        $offset = 0;
        $limit = 30;

        $result = DBManagerFactory::getInstance()->limitQuery($query, $offset, $limit);

        $echo = '<table>';
        $echo .= '<tr><th>' . $mod_strings['LBL_SUGGESTION_BOX_REL'] . '</th><th>' . $mod_strings['LBL_SUGGESTION_BOX_TITLE'] . '</th><th>' . $mod_strings['LBL_SUGGESTION_BOX_STATUS'] . '</th></tr>';
        $count = 1;
        while ($row = DBManagerFactory::getInstance()->fetchByAssoc($result)) {
            $kb = BeanFactory::getBean('AOK_KnowledgeBase', $row['id']);
            $echo .= '<tr class="kb_article" data-id="' . $kb->id . '">';
            $echo .= '<td> &nbsp;' . $count . '</td>';
            $echo .= '<td>' . $kb->name . '</td>';
            $echo .= '<td>' . $app_list_strings['aok_status_list'][$kb->status] . '</td>';
            $echo .= '</tr>';
            $count++;
        }
        $echo .= '</table>';

        if ($count > 1) {
            echo $echo;
        } else {
            echo $mod_strings['LBL_NO_SUGGESTIONS'];
        }
        die();
    }

    public function action_get_kb_article()
    {
        global $mod_strings;

        $article_id = $_POST['article'];
        $article = BeanFactory::newBean('AOK_KnowledgeBase');
        $article->retrieve($article_id);

        echo '<span class="tool-tip-title"><strong>' . $mod_strings['LBL_TOOL_TIP_TITLE'] . '</strong>' . $article->name . '</span><br />';
        echo '<span class="tool-tip-title"><strong>' . $mod_strings['LBL_TOOL_TIP_BODY'] . '</strong></span>' . html_entity_decode((string) $article->description);

        if (!$this->IsNullOrEmptyString($article->additional_info)) {
            echo '<hr id="tool-tip-separator">';
            echo '<span class="tool-tip-title"><strong>' . $mod_strings['LBL_TOOL_TIP_INFO'] . '</strong></span><p id="additional_info_p">' . $article->additional_info . '</p>';
            echo '<span class="tool-tip-title"><strong>' . $mod_strings['LBL_TOOL_TIP_USE'] . '</strong></span><br />';
            echo '<input id="use_resolution" name="use_resolution" class="button" type="button" value="' . $mod_strings['LBL_RESOLUTION_BUTTON'] . '" />';
        }

        die();
    }

    /**
     * Function for basic field validation (present and neither empty nor only white space
     * @param string $question
     * @return bool
     */
    private function IsNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question) === '');
    }

    // APX Custom Codes -- START
    // Deprecated feature in OnTrack 1259 -- replaced button to a dropdown field
    public function action_set_verification_status()
    {
        global $log;

        $customerIssueID = $_POST['id'];
        $value = $_POST['value'];

        $result = array(
            'success'=> false,
            'is_verified' => false
        );
        
        $customerIssueBean = BeanFactory::getBean('Cases', $customerIssueID);

        if ($customerIssueBean) {
            $customerIssueBean->verified_status_c =  ! $customerIssueBean->verified_status_c;
            $customerIssueBean->save();

            // Log change for Verification Status
            CustomerIssuesHelper::handleVerificationAudit($customerIssueBean);

            $result['success'] = true;
            $result['is_verified'] = $customerIssueBean->verified_status_c;
        }
        
        echo json_encode($result);
    }

    // Checks if An issue can be closed ONLY When it is VERIFIED and ALL Preventive Actions are closed
    public function action_check_related_preventive_actions()
    {
        global $log;

        $customerIssueID = $_POST['customer_issue_id'];

        $result = array(
            'success' => false,
            'can_close' => false
        );
        
        $customerIssueBean = BeanFactory::getBean('Cases', $customerIssueID);

        if ($customerIssueBean) {
            $canClose = $customerIssueBean->verified_status_c && CustomerIssuesHelper::checkPreventiveActions($customerIssueBean);
            $result['can_close'] = $canClose;
            $result['success'] = true;
        }
        
        echo json_encode($result);
    }

    // Checks if ALL Preventive actions ARE Closed
    public function action_check_closed_related_preventive_actions()
    {
        global $log;

        $customerIssueID = $_POST['customer_issue_id'];

        $result = array(
            'success' => false,
            'all_closed' => false
        );
        
        $customerIssueBean = BeanFactory::getBean('Cases', $customerIssueID);

        if ($customerIssueBean) {
            $all_closed = CustomerIssuesHelper::checkPreventiveActions($customerIssueBean);
            $result['all_closed'] = $all_closed;
            $result['success'] = true;
        }
        
        echo json_encode($result);
    }

    public function action_status_filtered()
    {
        global $log, $app_list_strings, $current_user; // $app_list_strings['status_list']
        
        $statusValue = $_GET['status'];
        $beanId = $_GET['record_id'];
        $isSubmittedDraft = $_GET['submit_draft'];

        $options = '';
        $customerIssueBean = BeanFactory::getBean('Cases', $beanId);
        $result = CustomerIssuesHelper::filterStatusOptions($statusValue);

        if ($beanId == "" && !$current_user->is_admin) {
            // On Create, status should only be Draft
            $result = array_filter($app_list_strings['status_list'], function($key) {
                return $key == 'Draft';
            }, ARRAY_FILTER_USE_KEY);
        }

        // On Submit Issue, force dropdown to be New only
        if ($beanId != "" && $isSubmittedDraft == "true" && !$current_user->is_admin) {
            $result = array_filter($app_list_strings['status_list'], function($key) {
                return $key == 'New' || $key == 'CreatedInError';
            }, ARRAY_FILTER_USE_KEY);
        }

        // (Special Case) On EDIT DRAFT issue, 
        if ($beanId != "" && $isSubmittedDraft == "false" && !$current_user->is_admin) {
            if ($customerIssueBean->status == 'Draft') {
                unset($result['New']);
            }
        }

        // (Special Case) 'Closed' can only be visible if current user is the site Internal Auditor and when Issue status is 5 - CAPA Completed - OnTrack 1259
        if ($beanId != "" && $customerIssueBean->status == 'CAPAComplete') {
            $workgroupUser = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['InternalAuditor']);
            $capaUserBean = ($workgroupUser)
                ? CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['InternalAuditor']) 
                : retrieveUserBySecurityGroupTypeDivision('Internal Auditor', 'CAPAWorkingGroup', $customerIssueBean->site_c, $customerIssueBean->division_c);

            $internalAuditor = is_array($capaUserBean) ? $capaUserBean[0] : $capaUserBean;

            if (isset($internalAuditor) && $current_user->id != $internalAuditor->id && !$current_user->is_admin) {
                unset($result['Closed']);
            }
        }

        foreach ($result as $key => $value) {
            
            $selected = $key == $statusValue ? 'selected' : '';
            $options .= "<option label='{$value}' value='{$key}' {$selected}>{$value}";
            $options .= "</option>";
        }
        echo $options;
    }

    public function action_get_cp_id(){
        global $log;

        $result = array('status' => false, 'data' => array());
        $product_name = (isset($_POST['product_name']) && !empty($_POST['product_name'])) ? $_POST['product_name'] : '';

        if(!empty($product_name)){
            $ci_cust_item_bean = BeanFactory::getBean('CI_CustomerItems');

            $where_query = "lower(ci_customeritems_cstm.product_number_c) = lower('{$product_name}')";

            $ci_cust_item_list = $ci_cust_item_bean->get_full_list('name', $where_query);

            if(count($ci_cust_item_list) > 0){
                $ci_cust_item = $ci_cust_item_list[0];
                $result['status'] = true;
                $result['data'] = $ci_cust_item->id;
            }
        }

        echo json_encode($result);
    }

    public function action_filter_return_authorization_by()
    {
        global $current_user;

        $options = '';
        $customerIssueBean = BeanFactory::getBean('Cases', $_GET['record_id']);

        // Need to add this here as division is not displayed on Editview and can't be via javascript AJAX request
        // Note: This should be before calling retrieveReturnAuthorizationByUserList as it checks for $_REQUEST['division']
        $_REQUEST['division'] = $customerIssueBean->division_c ?? $current_user->division_c;

        $userListArray = retrieveReturnAuthorizationByUserList();

        if ($customerIssueBean->return_authorization_number_c <> $_GET['return_authorization_by'] && $_GET['return_authorization_by'] <> '') {
            unset($userListArray[$_GET['return_authorization_by']]);
        }

        foreach ($userListArray as $key => $value) {
            $selected = $key == $_GET['return_authorization_by'] ? 'selected' : '';
            $options .= "<option label='{$value}' value='{$key}' {$selected}>{$value}</option>";
        }

        echo $options;
    }

    public function action_retrieve_lot_customer_product_details()
    {
        $customerProductDetails = [];

        $lotBean = BeanFactory::getBean('APX_Lots', $_REQUEST['product_lot_id']);
        $lotProductMasterBean = BeanFactory::getBean('AOS_Products', $lotBean->apx_lots_aos_productsaos_products_ida);
        $lotCustomerProductBean = BeanFactory::getBean('CI_CustomerItems');
        $lotCustomerProductBeanList = $lotCustomerProductBean->get_full_list('name', "lower(ci_customeritems_cstm.product_number_c) = lower('{$lotProductMasterBean->product_number_c}')");

        if (count($lotCustomerProductBeanList) > 0) {
            $lotCustomerProductBean = $lotCustomerProductBeanList[0];

            $customerProductDetails = [
                'id' => $lotCustomerProductBean->id,
                'name' => ($lotBean->name <> 'N/A') ? $lotCustomerProductBean->name : 'N/A',
                'number' => ($lotBean->name <> 'N/A') ? $lotCustomerProductBean->product_number_c : 'N/A'
            ];
        }

        echo json_encode($customerProductDetails);
    }
    // APX Custom Codes -- END
}
