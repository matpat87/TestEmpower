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

/*********************************************************************************

 * Description: This file is used to override the default Meta-data DetailView behavior
 * to provide customization specific to the Campaigns module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/json_config.php');
require_once('include/MVC/View/views/view.edit.php');
require_once('modules/Opportunities/views/view.edit.php');
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

class CustomOpportunitiesViewEdit extends OpportunitiesViewEdit {
 	function display() {
		global $app_list_strings, $log;

        $this->Duplicate();
        $this->bean->oppid_c = (! isset($this->bean->id)) ? 'TBD' : OpportunitiesHelper::assign_opportunity_id($this->bean->id);

		$this->bean->next_step_temp_c = ''; // for Task in OnTrack #5 - OPPORTUNITY - SCREEN CHANGES

		if(strpos($this->bean->amount, '$') === false)
		{
			$bean_amount = "$" . number_format($this->bean->amount, 2, '.', ',');
			$this->bean->amount = $bean_amount;
		}

		$this->bean->avg_sell_price_c = NumberHelper::GetCurrencyValue($this->bean->avg_sell_price_c);
		$this->bean->amount = NumberHelper::GetCurrencyValue($this->bean->amount);
		$this->bean->amount_weighted_c = NumberHelper::GetCurrencyValue($this->bean->amount_weighted_c);
		
		
		// For Industry and Sub-Industry dropdown field customized values
		if (!empty($this->bean->sub_industry_c)) {
			$industryBean = BeanFactory::getBean('MKT_Markets', $this->bean->sub_industry_c);
			$this->bean->sub_industry_c =  $industryBean->sub_industry_c;

			if (!empty($this->bean->industry_c)) {
				$this->bean->industry_c =  $industryBean->id;
			}
		}
		

		//this is useful for Calculating probability
		if($this->bean->id != '')
		{
			$opportunity_db_details = TechnicalRequestHelper::get_opportunity_details($this->bean->id);
			//$date = new DateTime($opportunity_db_details['date_modified']);
			//$date->format('m-d-Y H:i:s');
			$this->bean->custom_date_modified_str = $opportunity_db_details['date_modified'];
		}

		$this->_css_defaults();
		parent::display();
		$this->_js_defaults();
    }
    
    private function Duplicate()
    {
        if(isset($_POST['is_duplicate']) && $_POST['is_duplicate'] == 'true')
        {
            $fields_not_to_copy = array('id');

            $opportunity_bean = BeanFactory::getBean('Opportunities', $_POST['record_id']);

            foreach (get_object_vars($opportunity_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    $this->bean->$key = $value;
                }
            }
        }
    }

	private function _css_defaults(){
		echo <<<EOF
				<style type="text/css">
					#next_step_temp_c{
						width: 100%;
					}
				</style>
EOF;
	}
	 
	private function _js_defaults()
	{
		global $app_list_strings, $sugar_config;

		$related_trs = TechnicalRequestHelper::get_opportunity_trs($this->bean->id);
		$is_allow_edit = (count($related_trs) > 0) ? 'false' : 'true';
		$sales_stage_str = '[';

		foreach($app_list_strings['sales_stage_dom'] as $sales_stage_key => $sales_stage_val)
		{
			$sales_stage_str .= "['$sales_stage_key','$sales_stage_val'], " ;
		}

		// echo strlen($sales_stage_str);
		if(strlen($sales_stage_str) > 2)
		{
			// echo 'yeaahh';
			$sales_stage_str = substr($sales_stage_str, 0, strlen($sales_stage_str) - 2);
		}

		$sales_stage_str .= ']';

		// Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
		echo "<script src='custom/modules/Opportunities/js/custom-edit.js?v={$guid}'></script>";
		
		$js_str = "<script type='text/javascript'>
		var isAllowEdit = {$is_allow_edit};
		var sales_stage_dom = $sales_stage_str;
		var base_url = '". $sugar_config["site_url"] ."';
		var panel_bg_color = 'var(--custom-panel-bg)';
	
		$(\"div[field='workflow_section_non_db'], div[field='overview_section_non_db'],div[field='marketing_information_non_db'] \")
			.addClass('hidden')
			.prev()
			.removeClass('col-sm-2')
			.addClass('col-sm-12')
			.addClass('col-md-12')
			.addClass('col-lg-12')
			.css('background-color', panel_bg_color)
			.css('color', '#FFF')
			.css('margin-top', '15px')
			.css('padding', '0px 0px 8px 10px')
			.parent()
			.css('padding-left', '0px')
			.css('margin-top', '0px');

		$(\"div[field='workflow_section_non_db']\")
			.prev()
			.css('margin-top', '0px');

		$(\"div[field='workflow_section_non_db']\")
			.parent()
			.next()
			.next()
			.css('border', '1px solid')
			.css('border-color', panel_bg_color)
			.css('padding', '6px')
			.css('border-right', '0')
			.css('margin-top', '-12px')
			.next()
			.css('border', '1px solid')
			.css('border-color', panel_bg_color)
			.css('padding', '6px')
			.css('border-left', '0')
			.css('margin-top', '-12px')
			.css('margin-left', '-2px');

		$(document).ready(function(e){
			if(!isAllowEdit)
			{
				$('#avg_sell_price_c, #annual_volume_lbs_c, #probability_prcnt_c').attr('readonly', 'readonly');
				$('#sales_stage, #status_c').attr('disabled', 'true');
				$('#avg_sell_price_c, #annual_volume_lbs_c, #probability_prcnt_c, #sales_stage, #status_c')
					.attr('style', 'background: rgb(248, 248, 248); border: 1px solid rgb(226, 231, 235); cursor: not-allowed;');
					// InitializeSalesStage(true);
			}
			else
			{
				// InitializeSalesStage(false);
			}

		});</script>";

		echo $js_str;
	}
}
