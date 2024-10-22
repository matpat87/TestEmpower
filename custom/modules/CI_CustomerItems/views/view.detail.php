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


class CI_CustomerItemsViewDetail extends ViewDetail
{
 	public function __construct()
 	{
 		parent::__construct();
 		$this->useForSubpanel = true;
 		$this->useModuleQuickCreateTemplate = true;
 	}

 	function display(){

		global $app_list_strings, $log;
    
		if ($this->bean->id) {
			$this->bean->product_master_non_db = "{$this->bean->product_number_c}.{$this->bean->version_c}";
		}

		if ($this->bean->mkt_markets_ci_customeritems_1_name != '' && $this->bean->mkt_markets_ci_customeritems_1mkt_markets_ida != '') {
			$industryLink ="<a href='index.php?module=MKT_Markets&amp;action=DetailView&amp;record={$this->bean->mkt_markets_ci_customeritems_1mkt_markets_ida}'><span id='mkt_markets_ci_customeritems_1mkt_markets_ida' class='sugar_field' data-id-value='{$this->bean->mkt_markets_ci_customeritems_1mkt_markets_ida}'>{$app_list_strings['industry_dom'][$this->bean->industry_c]}</span>";
		} else {
			$industryLink = $app_list_strings['industry_dom'][$this->bean->industry_c];
		}

		if (!empty($this->bean->sub_industry_c)) {
			$industryBean = BeanFactory::getBean("MKT_Markets", $this->bean->sub_industry_c);
			$subIndustryStr = $industryBean->sub_industry_c;
		} else {
		$subIndustryStr = "";
		}

		$this->ss->assign('INDUSTRY_NAME', $industryLink);
		$this->ss->assign('SUB_INDUSTRY_NAME', $subIndustryStr);
		
		
		echo getVersionedScript('custom/modules/CI_CustomerItems/js/detail.js');

		$this->AddSections();
		$this->setFieldsDisplayToDollar();
		$this->setFieldsDisplayToPercent();
		parent::display();
	 }
	 
	 private function setFieldsDisplayToDollar()
	{
		$fieldsArray = [
			'budget_jan', 'budget_feb', 'budget_mar', 'budget_apr', 'budget_may', 'budget_jun',
			'budget_jul', 'budget_aug', 'budget_sep', 'budget_oct', 'budget_nov', 'budget_dec',
			'ytd_forecast_c', 'annual_forecast_c', 'total_sales_c', 'sales_last_year_c', 'sales_pytd_c', 'sales_cytd_c'
		];

		foreach ($fieldsArray as $field) {
			$fieldVal = $this->bean->$field && $this->bean->$field !== '' ? $this->bean->$field : 0;
			$this->ss->assign(strtoupper($field), "$" . number_format($fieldVal, 2));
		}
		
	}

	private function setFieldsDisplayToPercent()
	{
		$fieldsArray = [
			'margin', 'margin_prior_year_c', 'margin_current_year_c', 'material_margin_py_c', 'material_margin_cy_c'
		];

		foreach ($fieldsArray as $field) {
			$fieldVal = $this->bean->$field && $this->bean->$field !== '' ? $this->bean->$field : 0;
			$this->ss->assign(strtoupper($field), number_format($fieldVal, 2) . '%');
		}
	}

	private function addSections()
	{
		$fields_js = "div[field='sales_panel_label_non_db'], div[field='sales_forecast_panel_label_non_db'], div[field='sales_margin_panel_label_non_db']";

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

				$(\"div[field='marketing_information_non_db']\")
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
			});
		</script>";
	}
}