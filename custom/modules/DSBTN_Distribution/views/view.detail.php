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
require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');

class DSBTN_DistributionViewDetail extends ViewDetail {


 	function __construct(){
 		parent::__construct();
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

		if(empty($this->bean->id)){
			global $app_strings;
			sugar_die($app_strings['ERROR_NO_RECORD']);
		}

		$this->dv->process();
		
		echo $this->dv->display();
		$this->AddSections();
		$this->AddDistributionItems($this->bean->id);
		$this->setShipToAddressIndicator($this->bean->ship_to_address_c);
		// $this->showOrHideEditButton($this->bean->tr_technicalrequests_id_c);
	 }

	 private function AddDistributionItems($bean_id)
	 {
		$tr_html = DistributionHelper::GetDistributionItemsDetailView('DSBTN_Distribution', $bean_id);

		echo "<script type=\"text/javascript\">
				$(document).ready(function(e){
					$('#tbl_line_items tbody').append('$tr_html');
				});
			</script>";
	 }

	 private function AddSections()
	 {
		 $fields_js = "div[field='custom_recipient_information_label_non_db'], div[field='custom_overview_label_non_db'], div[field='custom_distribution_items_label_non_db']";
 
		 echo 
		 "<script>
			 $(document).ready(function(){
				 var panel_bg_color = 'var(--custom-panel-bg)';
		 
				 $(\"$fields_js\")
					 .prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 8px 10px').parent().css('padding-left', '0px');
 
				 $(\"$fields_js\")
					 .prev().css('margin-top', '0px');
 
				 $(\"$fields_js\")
					 .addClass('hidden');
 
				 $(\"div[field='custom_line_items_non_db']\").parent().find('div:first').hide();
				 $(\"div[field='custom_line_items_non_db']\").removeClass('col-sm-8').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12');
			 });
		 </script>";
	 }

	 private function setShipToAddressIndicator($shipToAddressValue)
	 {
		if ($shipToAddressValue == 'primary_address') {
			$divField = 'primary_address_street';
		} else if ($shipToAddressValue == 'other_address') {
			$divField = 'alt_address_street';
		} else {
			return;
		}

		echo $divField ? "<script> $(`div[field='{$divField}']`).css('border', '1px solid green').parent().first().css('color', 'green'); </script>" : '';
	 }

	 private function showOrHideEditButton($trId)
	 {
		$trBean = BeanFactory::getBean('TR_TechnicalRequests', $trId);

		if ($trBean && (! ((in_array($trBean->approval_stage, ['understanding_requirements', 'development'])) && (in_array($trBean->status, ['new', 'more_information', 'approved']))) )) {
			echo "<script> 
				jQuery( () => {
					$('#edit_button').parent().remove();
				});
			</script>";
		}
	 }
}

