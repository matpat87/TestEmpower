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

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelRemoveButton.php');

class SugarWidgetSubPanelRollupRemoveButton extends SugarWidgetSubPanelRemoveButton
{
    function displayHeaderCell($layout_def)
    {
        return '&nbsp;';
    }

    function displayList(&$layout_def)
    {

        global $app_strings;
        global $subpanel_item_count;

        $unique_id = $layout_def['subpanel_id'] . "_remove_" . $subpanel_item_count; //bug 51512

        $parent_record_id = $_REQUEST['record'];
        $parent_module = $_REQUEST['module'];

		$action = 'DeleteRelationship';
		$record = $layout_def['fields']['ID'];
		$current_module=$layout_def['module'];
		//in document revisions subpanel ,users are now allowed to 
		//delete the latest revsion of a document. this will be tested here
		//and if the condition is met delete button will be removed.
		$hideremove=false;
		if ($current_module==='DocumentRevisions') {
			if ($layout_def['fields']['ID']===$layout_def['fields']['LATEST_REVISION_ID']) {
				$hideremove=true;
			}
		}elseif ($_REQUEST['module'] === 'Teams' && $current_module === 'Users') {
		// Implicit Team-memberships are not "removeable"

			if($layout_def['fields']['UPLINE'] !== translate('LBL_TEAM_UPLINE_EXPLICIT', 'Users')) {
				$hideremove = true;
			}

			//We also cannot remove the user whose private team is set to the parent_record_id value
			$user = new User();
			$user->retrieve($layout_def['fields']['ID']);
			if($parent_record_id === $user->getPrivateTeamID()){

			    $hideremove = true;
			}} elseif ($current_module === 'ACLRoles' && (!ACLController::checkAccess($current_module, 'edit', true))) {
            $hideremove = true;
		}elseif ($current_module === 'ACLRoles' && (!ACLController::checkAccess($current_module, 'edit', true))) {
            $hideremove = true;
		}
		
		$return_module = $_REQUEST['module'];
		$return_action = 'SubPanelViewer';
		$subpanel = $layout_def['subpanel_id'];
		$return_id = $_REQUEST['record'];
		if (isset($layout_def['linked_field_set']) && !empty($layout_def['linked_field_set'])) {
			$linked_field= $layout_def['linked_field_set'] ;
		} else {
			$linked_field = $layout_def['linked_field'];
		}
		$refresh_page = 0;
		if(!empty($layout_def['refresh_page'])){
			$refresh_page = 1;
		}
		$return_url = "index.php?module=$return_module&action=$return_action&subpanel=$subpanel&record=$return_id&sugar_body_only=1&inline=1";

        $icon_remove_text = $app_strings['LBL_ID_FF_REMOVE'];

        if ($linked_field === 'get_emails_by_assign_or_link') {
            $linked_field = 'emails';
        }

		if ($parent_module === 'Accounts') {
			$childAccountRelationshipName = 'accounts'; // default core child - account relationship name

			if ($linked_field === 'contacts') {
				$childBean = BeanFactory::getBean('Contacts', $record);
			}
	
			if ($linked_field === 'opportunities') {
				$childBean = BeanFactory::getBean('Opportunities', $record);
			}

			if ($linked_field === 'accounts_comp_competition_1') {
				$childBean = BeanFactory::getBean('COMP_Competition', $record);
				$childAccountRelationshipName = 'accounts_comp_competition_1';
			}

            if ($linked_field === 'accounts_chl_challenges_1') {
				$childBean = BeanFactory::getBean('CHL_Challenges', $record);
				$childAccountRelationshipName = 'accounts_chl_challenges_1';
			}

			$accountBean = (isset($childBean) && $childBean != null) ? $childBean->get_linked_beans(
				$childAccountRelationshipName, 'Accounts', array(), 0, -1, 0,
				"accounts.id = '{$_REQUEST['record']}'"
			) : null;

			$hideremove = (isset($accountBean) && $accountBean != null && count($accountBean) > 0) ? false : true;
		}

        if ($parent_module === 'CI_CustomerItems') {
            if ($linked_field === 'rd_regulatorydocuments_ci_customeritems_1') {
                $childBean = BeanFactory::getBean('RD_RegulatoryDocuments', $record);
                $childCustomerProductRelationshipName = 'rd_regulatorydocuments_ci_customeritems_1';
            }

            $customerProductBean = (isset($childBean) && $childBean != null) ? $childBean->get_linked_beans(
                $childCustomerProductRelationshipName, 'CI_CustomerItems', array(), 0, -1, 0,
                "ci_customeritems.id = '{$_REQUEST['record']}'"
            ) : null;

            $hideremove = (isset($customerProductBean) && $customerProductBean != null && count($customerProductBean) > 0) ? false : true;
        }

        if ($parent_module === 'RD_RegulatoryDocuments') {
            if ($linked_field === 'rd_regulatorydocuments_ci_customeritems_1') {
                $childBean = BeanFactory::getBean('CI_CustomerItems', $record);
                $childCustomerProductRelationshipName = 'rd_regulatorydocuments_ci_customeritems_1';
            }

            $customerProductBean = (isset($childBean) && $childBean != null) ? $childBean->get_linked_beans(
                $childCustomerProductRelationshipName, 'RD_RegulatoryDocuments', array(), 0, -1, 0,
                "rd_regulatorydocuments.id = '{$_REQUEST['record']}'"
            ) : null;

            $hideremove = (isset($customerProductBean) && $customerProductBean != null && count($customerProductBean) > 0) ? false : true;
        }

        //based on listview since that lets you select records
        if ($layout_def['ListView'] && !$hideremove) {
            $retStr = "<a href=\"javascript:sub_p_rem('$subpanel', '$linked_field'"
                . ", '$record', $refresh_page);\""
                . ' class="listViewTdToolsS1"'
                . "id=$unique_id"
                . " onclick=\"return sp_rem_conf();\""
                . ">$icon_remove_text</a>";

            return $retStr;

        }

        return '';

    }
}
