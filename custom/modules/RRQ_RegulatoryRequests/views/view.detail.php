<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2010 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

require_once('include/MVC/View/views/view.detail.php');

class RRQ_RegulatoryRequestsViewDetail extends ViewDetail {


 	function __construct(){
 		parent::__construct();
 	}


	 public function preDisplay()
    {
        parent::preDisplay();
    }


 	/**
 	 * display
 	 * Override the display method to support customization for the buttons that display
 	 * a popup and allow you to copy the account's address into the selected contacts.
 	 * The custom_code_billing and custom_code_shipping Smarty variables are found in
 	 * include/SugarFields/Fields/Address/DetailView.tpl (default).  If it's a English U.S.
 	 * locale then it'll use file include/SugarFields/Fields/Address/en_us.DetailView.tpl.
 	 */
 	function display(){
		global $app_list_strings, $timedate;

		if(empty($this->bean->id)){
			global $app_strings;
			sugar_die($app_strings['ERROR_NO_RECORD']);
		}
		$this->bean->status_update_log_c =  htmlspecialchars_decode($this->bean->status_update_log_c);

        $this->ss->assign('BTN_SUBMIT_FOR_REVIEW_HTML', $this->getSubmitForReviewHTML());
		$this->dv->process();
		$this->customStyles();
		echo $this->dv->display();
	 }

	private function getSubmitForReviewHTML()
	{
		$result = '';
		
		if (in_array($this->bean->status_c, ['draft', 'awaiting_more_info'])) {
			$result = '<form action="index.php?module=RRQ_RegulatoryRequests&action=EditView&return_module=RRQ_RegulatoryRequests&return_action=DetailView" method="POST" name="CustomForm" id="form">
				<input type="hidden" name="is_submit_for_review" id="is_submit_for_review" value="true">
				<input type="hidden" name="reg_req_request_id" id="reg_req_request_id" value="'. $this->bean->id .'">
				<input type="submit" name="btnSubmitForReview" id="btnSubmitForReview" title="Submit for Review" class="button" value="Submit for Review">
				</form>';
		}

		return $result;
	}

	private function customStyles()
	{
		global $current_user, $sugar_config;
        $conditionalStyles = "
            li > input#edit_button {
                display: none;
            }";
        
        $regulatoryManagerUserBean = retrieveUserBySecurityGroupTypeDivision('Regulatory Manager', 'RRWorkingGroup', NULL, $this->bean->division_c);
		// Ontrack #1937 Disable Edit if Reg Request is status = 'Complete' (but allow for Admins and Regulatory Manager Roles)
		if ($this->bean->status_c == 'complete' && (!$current_user->is_admin) && ($current_user->id != $regulatoryManagerUserBean->id)) {

			if ($sugar_config['isQA']) {

				echo "
					<script>
						jQuery(function() {
							jQuery('a').has('span.suitepicon-action-edit').parent('li').attr('id', 'qa-edit-btn');
							jQuery('#qa-edit-btn').css('visibility','hidden')
						});
					</script>
				";
			}
		}

		echo "
			<style>
			#status_update_log_c, #description {
				height: 200px;
				line-height: 20px;
				display: block;
				padding-top: 5px;
				overflow-y:scroll;
			}
			{$conditionalStyles}
			</style>
		";
	}
}

