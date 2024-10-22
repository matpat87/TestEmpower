<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/

require_once('custom/modules/Accounts/helpers/accountHelper.php');

class AccountsViewEdit extends ViewEdit
{
 	public function __construct()
 	{
 		parent::__construct();
 		$this->useForSubpanel = true;
 		$this->useModuleQuickCreateTemplate = true;
 	}

 	function display(){
		 global $log;
		
		if (! $this->ev->focus->id) {
			$this->ev->focus->division_c = 'Color';
		}

        $this->populate_parent_color_spend(); //OnTrack #1244
		parent::display();

		if ($this->ev->focus->fetched_row['integration_date_c']) {
			echo "
				<script>
					$(document).ready(function() {
						$(\"#billing_address_street, #billing_address_city, #billing_address_state, #billing_address_postalcode, #billing_address_country, #account_class_c\")
					.attr('disabled', 'disabled')
					.css('background', '#f8f8f8')
					.css('border', '1px solid #e2e7eb');
					});
				</script>
			
			";
		}

		// Hide input fields so that custom non-db fields will display labels only
		// Added by: Ralph Julian Siasat
		echo 
		"<script>
			$(document).ready(function(){
				var panel_bg_color = 'var(--custom-panel-bg)';
		
				$(\"div[field='marketing_information_non_db'],div[field='erp_data_non_db']\").prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 8px 10px').parent().css('padding-left', '0px');

				$(\"div[field='marketing_information_non_db']\").prev().css('margin-top', '0px');
				
				$(\"div[field='marketing_information_non_db'],div[field='erp_data_non_db']\").addClass('hidden');

				
			});
		</script>";
 	}

    //OnTrack #1244
    private function populate_parent_color_spend(){
        if($this->bean->account_type == 'CustomerParent'){
            // $this->bean->annual_revenue_potential_c = AccountHelper::retrieve_total_color_spend($this->bean->id); // Ontrack 1681: total annannual_revenue_potential_c of child accounts is no longer needed and is depracated
        }

        $this->ev->focus->annual_revenue_potential_c = NumberHelper::GetCurrencyValue($this->bean->annual_revenue_potential_c);
		$this->ev->focus->annual_revenue = NumberHelper::GetCurrencyValue($this->bean->annual_revenue);
    }

}