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
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');

class TR_TechnicalRequestsViewDetail extends ViewDetail {


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

		$this->bean->avg_sell_price_c = NumberHelper::GetCurrencyValue($this->bean->avg_sell_price_c);
		$this->bean->annual_amount_c = NumberHelper::GetCurrencyValue($this->bean->annual_amount_c);
		$this->bean->price_c = NumberHelper::GetCurrencyValue($this->bean->price_c);
		$this->bean->updates = htmlspecialchars_decode($this->bean->updates);
		$this->bean->annual_amount_weighted_c = NumberHelper::GetCurrencyValue($this->bean->annual_amount_weighted_c);
		
		if ($this->bean->approval_stage && $this->bean->status) {

			$status = TechnicalRequestHelper::get_status($this->bean->approval_stage, $this->bean->approval_stage, $this->bean->status)[$this->bean->status];
			if ($status == 'Draft') {
				$status = "<b style='color: #fd7403; text-transform:uppercase;'>{$status}</b>";
			}
		}

		$this->ss->assign('CUSTOM_STATUS_DISPLAY', $status ?? '');

		$this->bean->load_relationship('tr_technicalrequests_aos_products_2');
		$productMasterBeans = $this->bean->tr_technicalrequests_aos_products_2->getBeans();

		if(count($productMasterBeans) > 0 || (! in_array($this->bean->type, ['color_match', 'rematch', 'cost_analysis', 'ld_optimization']))) {
			echo '<style> #subpanel_tr_technicalrequests_aos_products_2 ul.clickMenu.fancymenu.SugarActionMenu > li.sugar_action_button { display: none; } </style>';
		}

		if ($this->bean->approval_stage !== 'development') {
			echo '<style> #subpanel_tr_technicalrequests_aos_products_2 ul.clickMenu.fancymenu.SugarActionMenu > li.sugar_action_button { display: none; } </style>';
		} else {
			if (in_array($this->bean->type, ['rematch', 'cost_analysis', 'ld_optimization']) && ! in_array($this->bean->colormatch_type_c, ['product_master', 'product_version'])) {
				echo '<style> #subpanel_tr_technicalrequests_aos_products_2 ul.clickMenu.fancymenu.SugarActionMenu > li.sugar_action_button { display: none; } </style>';
			}
		}
		
		if (! in_array($this->bean->approval_stage, ['understanding_requirements', 'development', 'quoting_or_proposing', 'sampling'])) {
			echo '<style> #subpanel_tr_technicalrequests_dsbtn_distributionitems_1 ul.clickMenu.fancymenu.SugarActionMenu > li.single > form > a#tr_technicalrequests_dsbtn_distributionitems_1_edit_1 { display: none; } </style>';
		}

		if ($this->bean->type !== 'color_match') {
			echo '<style> #subpanel_tr_technicalrequests_aos_products_2 ul.clickMenu.fancymenu.SugarActionMenu > li.sugar_action_button > span.suitepicon.suitepicon-action-caret { display: none; } </style>';
		}

		if (! empty($this->bean->product_category_c)) {
			$product_category_bean = BeanFactory::getBean('AOS_Product_Categories', $this->bean->product_category_c);
			$product_category_id = $product_category_bean->id;
			$product_category_name = $product_category_bean->name;
		}

		if ($this->bean->type !== 'product_sample') {
			// If Product # (Customer Products) relate field is populated, set CUSTOM_NAME as Anchor Tag with redirect to Customer Products, else set TR Product Name value
			if ($this->bean->ci_customeritems_tr_technicalrequests_1ci_customeritems_ida) {
				$customerProductBean = BeanFactory::getBean('CI_CustomerItems', $this->bean->ci_customeritems_tr_technicalrequests_1ci_customeritems_ida);
	
				$this->ss->assign(
					'CUSTOM_NAME', 
					"<a href='/index.php?module={$customerProductBean->module_dir}&offset=1&return_module={$customerProductBean->module_dir}&action=DetailView&record={$customerProductBean->id}'>{$this->bean->name}</a>"
				);
			} else {
				$this->ss->assign('CUSTOM_NAME', $this->bean->name);
			}
		} else {
			$productMasterBean = BeanFactory::getBean('AOS_Products')->retrieve_by_string_fields(
                array(
                    "product_number_c" => $this->bean->name,
                ), false, true
            );

            // If Product # (Product Master) relate field is populated, set relate field name value as product_number_c instead of name
            if ($productMasterBean && $productMasterBean->id) {
                $this->ss->assign(
					'CUSTOM_NAME', 
					"<a href='/index.php?module={$productMasterBean->module_dir}&offset=1&return_module={$productMasterBean->module_dir}&action=DetailView&record={$productMasterBean->id}'>{$this->bean->name}</a>"
				);
            } else {
				$this->ss->assign('CUSTOM_NAME', $this->bean->name);
			}
		}
        
        /*
         * Ontrack 1966: Display Account name with ALT SYS ID
         * */
        if ($this->bean->load_relationship('tr_technicalrequests_accounts')) {
            $trAccount = $this->bean->tr_technicalrequests_accounts->getBeans();
            $trAccount = array_shift($trAccount);
            $altSysId = ($trAccount && !empty($trAccount->alt_sys_id_c)) ? " (" . trim($trAccount->alt_sys_id_c) . ")" : '';
            $this->bean->tr_technicalrequests_accounts_name = "{$trAccount->name}{$altSysId}" ?? '';
        }

		/* OnTrack #1933: Show Copy Full Option for all Open TR's (TR != Closed - ***) */
		$showCopyFull = ($this->bean->type == 'color_match' && (!in_array($this->bean->approval_stage, ['closed', 'closed_won', 'closed_lost', 'closed_rejected'])));

		/* 	Ontrack #1685:
			Action Item - Rematch Rejected CMR display only
			if TR is Stage == Closed Lost && Type = ColorMatch
		*/
		$rematchRejectedCMRdisplay = ($this->bean->approval_stage == 'closed_lost' && $this->bean->type == 'color_match');

		/* OnTrack #1651: Show Rematch Version only when stage is ['Understanding Requirements' ,'Development'] prior to completing */
		$rematchVersiondisplay = (in_array($this->bean->approval_stage, ['understanding_requirements', 'development']) && in_array($this->bean->status, ['new', 'approved', 'in_process']));
		
		$this->ss->assign('PRODUCT_CATEGORY_ID', isset($product_category_id) ? $product_category_id : '');
		$this->ss->assign('PRODUCT_CATEGORY_NAME', isset($product_category_name) ? $product_category_name : '');
		$this->ss->assign('TECHNICAL_REQUEST_ID', $this->bean->id);
		$this->ss->assign('BTN_SUBMIT_TO_DEV_HTML', $this->getSubmitToDevHTML());
		$this->ss->assign('BTN_FIND_DUPLICATES_HTML', $this->getFindDuplicatesHTML());
		$this->ss->assign('SHOW_OR_HIDE_TR_PRINTOUT_ACTION_BTN', TechnicalRequestHelper::showOrHideTRPrintoutActionButton($this->bean));
		$this->ss->assign('DATE_ENTERED', date($timedate->getInstance()->get_date_format(), strtotime(handleRetrieveBeanDateEntered($this->bean))));
		$this->ss->assign('SHOW_OR_HIDE_COPY_BUTTONS', $this->bean->type == 'color_match' ? true : false);
		$this->ss->assign('SHOW_OR_HIDE_COPY_FULL_BUTTON', $showCopyFull);
		$this->ss->assign('SHOW_OR_HIDE_REMATCH_REJECTED_CMR', $rematchRejectedCMRdisplay);
		$this->ss->assign('SHOW_OR_HIDE_REMATCH_VERSION', $rematchVersiondisplay);
		$this->ss->assign('SHOW_CREATE_COVER_LETTER', $this->displayCreateCoverLetterActionItem());

		$this->CustomAmount($this->bean);

        $this->AddDefaults();
		$this->dv->process();
		$this->AddCSS();
		$this->showOrHideColormatchAndRegulatoryTabs();
        $this->handleLastActivityDateDisplay();

		echo $this->dv->display();
		$this->AddSections();
		$this->setCustomSessions();

		// Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/TR_TechnicalRequests/js/detail.js?v={$guid}'></script>";
	 }

	function CustomAmount($bean){
		if(isset($bean->target_price_c))
		{
			$amount = "$" . number_format($bean->target_price_c, 2, '.', ',');
			$this->ss->assign('TARGET_PRICE', $amount);
		}
    }
    
    private function AddDefaults()
    {
        if(!empty($this->bean->tr_technicalrequests_id_c))
        {
            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $this->bean->tr_technicalrequests_id_c);
            $this->bean->related_technical_request_c = TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
        }
    }

	private function AddSections()
	{
		$fields_js = "div[field='product_information_non_db'], div[field='custom_competitor_information_label_non_db'], div[field='custom_special_testing_label_non_db']," .
			"div[field='custom_customer_base_label_non_db'], div[field='custom_stability_label_non_db'], div[field='custom_opacity_texture_label_non_db']," .
			"div[field='custom_tolerance_label_non_db'], div[field='custom_additives_label_non_db'], div[field='custom_fda_label_non_db'], div[field='custom_resin_info_concentrate_label_non_db'], div[field='product_information_panel_non_db'], div[field='physical_material_properties_panel_non_db'], div[field='customer_certifications_panel_non_db']";

		echo 
		"<script>
			$(document).ready(function(){
				var panel_bg_color = 'var(--custom-panel-bg)';
				
				$(\"div[field='workflow_section_non_db'], div[field='overview_section_non_db'], div[field='product_information_panel_non_db']\")
					.addClass('hidden')
					.prev()
					.removeClass('col-sm-2')
					.addClass('col-sm-12')
					.addClass('col-md-12')
					.addClass('col-lg-12')
					.css('background-color', panel_bg_color)
					.css('color', '#FFF')
					.css('margin-top', '15px');

				$(\"div[field='workflow_section_non_db'], div[field='product_information_panel_non_db']\")
					.prev()
					.css('margin-top', '0px');

				$(\"$fields_js\")
					.prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 10px 10px').parent().css('padding-left', '0px');

				$(\"$fields_js\")
					.prev().css('margin-top', '0px');

				$(\"$fields_js\")
					.addClass('hidden');

				$(\"div[field='custom_line_items_non_db']\").parent().find('div:first').hide();
				$(\"div[field='custom_line_items_non_db']\").removeClass('col-sm-8').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12');
			});
		</script>";
	}

	private function AddCSS()
	{
		echo '<link rel="stylesheet" href="custom/modules/TR_TechnicalRequests/css/style.css" type="text/css">';
	}

	private function setCustomSessions()
	{
		// Used for passing TR Opportunity ID to TR Distro Popup
		//  Session used in function create_new_list_query on file DSBTN_Distribution.php
		$_SESSION['tr_id'] = $this->bean->id;
		$_SESSION['tr_opportunity_id'] = $this->bean->tr_technicalrequests_opportunitiesopportunities_ida;
	}

	//OnTrack 671 - Submit For Development
	private function getSubmitToDevHTML()
	{
		$result = '';
		
		if($this->bean->approval_stage == 'understanding_requirements' 
			&& in_array($this->bean->status, ['in_process', 'more_information'])){
			$result = '<form action="index.php?module=TR_TechnicalRequests&action=EditView&return_module=TR_TechnicalRequests&return_action=DetailView" method="POST" name="CustomForm" id="form">
				<input type="hidden" name="is_submit_for_development" id="is_submit_for_development" value="true">
				<input type="hidden" name="technical_request_id" id="technical_request_id" value="'. $this->bean->id .'">
				<input type="submit" name="duplicate" id="duplicate" title="Copy Version" class="button" value="Submit for Development">
				</form>';
		}

		return $result;
	}

	private function getFindDuplicatesHTML()
	{
		return "<input title=\"Find Duplicates\" class=\"button\" onclick=\"var _form = document.getElementById('formDetailView'); _form.return_module.value='TR_TechnicalRequests'; _form.return_action.value='DetailView'; _form.return_id.value='". $this->bean->id ."'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);\" type=\"button\" name=\"Merge\" value=\"Find Duplicates\" id=\"merge_duplicate_button\">";


	}

	private function showOrHideColormatchAndRegulatoryTabs()
	{
		if (! in_array($this->bean->type, ['color_match', 'rematch', 'cost_analysis', 'ld_optimization'])) {
			echo '<style> #tab1, #tab2 { display: none; }</style>';
		}
	}

    private function handleLastActivityDateDisplay()
    {
        if ($this->bean->last_activity_type_c && $this->bean->last_activity_id_c) {
            $customActivityType = $this->bean->last_activity_type_c;
            $customActivityLink = "/index.php?module={$customActivityType}&offset=1&return_module={$customActivityType}&action=DetailView&record={$this->bean->last_activity_id_c}";
            $this->ss->assign("custom_last_activity_link", $customActivityLink);
        }
    }

	/* Ontrack #1935: Show or hide Action Item: Create Cover letter */
	private function displayCreateCoverLetterActionItem()
	{
		global $log, $current_user;

		$colormatchTri = $this->bean->get_linked_beans(
			'tri_technicalrequestitems_tr_technicalrequests',
			'TRI_TechnicalRequestItems',
			array(), 0, -1, 0,
			"tri_technicalrequestitems.name = 'colormatch_task'"
		);


		// Display for admin, Lab (R&D Manager), Colormatch Coordinator, and Colormatcher
		$userBeans = TRWorkingGroupHelper::getWorkgroupUsers($this->bean, ['ColorMatcher', 'RDManager', 'ColorMatchCoordinator']);
		$userIds = array_column($userBeans, 'id');


		$display = false;

		if ((($current_user->is_admin) || in_array($current_user->id, $userIds))
				&& (in_array($this->bean->type, ['color_match', 'rematch', 'chips_only', 'product_sample'])
					 && in_array($this->bean->approval_stage, ['development', 'sampling', 'quoting_or_proposing', 'award_eminent'])
					 && (!empty($colormatchTri)) && ($colormatchTri[0]->status == 'complete'))) {

			if ($this->bean->approval_stage == 'development' && in_array($this->bean->status, ['approved', 'in_process'])) {

				$display = true;

			} elseif ($this->bean->approval_stage == 'development' && (!in_array($this->bean->status, ['approved', 'in_process']))) {

				$display = false;

			} else {

				$display = true;

			}
		}


		return $display;
	}
}

