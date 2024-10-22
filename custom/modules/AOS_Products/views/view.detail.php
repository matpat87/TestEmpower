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
require_once('custom/modules/AOS_Products/helper/ProductHelper.php');
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

class AOS_ProductsViewDetail extends ViewDetail {


 	function __construct(){
 		parent::__construct();
 	}


	 public function preDisplay()
    {
        parent::preDisplay();
    }

 	function display(){

		if(empty($this->bean->id)){
			global $app_strings;
			sugar_die($app_strings['ERROR_NO_RECORD']);
		}

		$this->ss->assign('PRODUCT_ID', $this->bean->id);

		$product_category_id = '';
		$product_category_name = '';
		if(!empty($this->bean->product_category_c)){
			$product_category_bean = BeanFactory::getBean('AOS_Product_Categories', $this->bean->product_category_c);
			$product_category_id = $product_category_bean->id;
			$product_category_name = $product_category_bean->name;
		}

		//Colormatch #227 - TR Printout
		$this->bean->load_relationship('tr_technicalrequests_aos_products_2');
		$tr_beans = $this->bean->tr_technicalrequests_aos_products_2->getBeans();
		$related_tr_id = '';
		if(count($tr_beans) > 0){
			$tr_bean = array_values($tr_beans)[0];
			$related_tr_id = $tr_bean->id;
		}

		$this->ss->assign('TECHNICAL_REQUEST_ID', $related_tr_id );
		$this->ss->assign('PRODUCT_CATEGORY_ID', $product_category_id );
		$this->ss->assign('PRODUCT_CATEGORY_NAME', $product_category_name);
		$this->ss->assign('SHOW_OR_HIDE_TR_PRINTOUT_ACTION_BTN', TechnicalRequestHelper::showOrHideTRPrintoutActionButton($tr_bean));
		
		$this->AddSections();
		$this->setFieldsDisplayToDollar();
		$this->setFieldsDisplayToPercent();
		$this->SetRelatedTo();
		$this->dv->process();
		echo $this->dv->display();

		// Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/AOS_Products/js/detail.js?v={$guid}'></script>";
	}

	private function SetRelatedTo()
	{
		if(!empty($this->bean->aos_products_id_c))
		{
			$product_bean = BeanFactory::getBean('AOS_Products', $this->bean->aos_products_id_c);
			$this->bean->related_product_c = ProductHelper::get_product_num_with_version($product_bean);
		}
	}

	private function setFieldsDisplayToDollar()
	{
		$fieldsArray = [
			'budget_jan_c', 'budget_feb_c', 'budget_mar_c', 'budget_apr_c', 'budget_may_c', 'budget_jun_c',
			'budget_jul_c', 'budget_aug_c', 'budget_sep_c', 'budget_oct_c', 'budget_nov_c', 'budget_dec_c',
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
			'margin_c', 'margin_prior_year_c', 'margin_current_year_c', 'material_margin_py_c', 'material_margin_cy_c'
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
				
				$(\"div[field='workflow_section_non_db'], div[field='overview_section_non_db']\")
				.addClass('hidden')
				.prev()
				.removeClass('col-sm-2')
				.addClass('col-sm-12')
				.addClass('col-md-12')
				.addClass('col-lg-12')
				.css('background-color', panel_bg_color)
				.css('color', '#FFF')
				.css('margin-top', '15px');

				$(\"div[field='workflow_section_non_db']\")
				.prev()
				.css('margin-top', '0px');

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
}

