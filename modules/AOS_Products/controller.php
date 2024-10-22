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
/*
 * Created on Mar 23, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once('include/MVC/Controller/SugarController.php');
 require_once('custom/modules/AOS_Products/helper/ProductHelper.php'); // APX Custom Codes
  
 #[\AllowDynamicProperties]
 class AOS_ProductsController extends SugarController
 {
     public function action_editview()
     {
         $this->view = 'edit';
         $GLOBALS['view'] = $this->view;
         if (!empty($_REQUEST['deleteAttachment'])) {
             ob_clean();
             echo $this->bean->deleteAttachment($_REQUEST['isDuplicate']) ? 'true' : 'false';
             sugar_cleanup(true);
         }
     }

    // APX Custom Codes -- START
    public function action_get_status()
    {
		global $log;

        $result = array('success' => true, 'data' => array());
		$typeParam = ($_POST != null && !empty($_POST['type'])) ? $_POST['type'] : '';

		$result['data'] = ProductHelper::get_statuses($typeParam);
        
        echo json_encode($result);
	}
	
    public function action_get_tr()
    {
		global $app_list_strings, $log, $timedate;

		// Retrieve logged user timezone
		$timezone = $timedate->getInstance()->userTimezone();

		// Retrieve logged user date format
		$userDateFormat = $timedate->getInstance()->get_date_format();
		
        $result = array('success' => true, 'data' => array());
		$technical_request_id = ($_REQUEST != null && !empty($_REQUEST['technical_request_id'])) ? $_REQUEST['technical_request_id'] : '';
		$product_id = ($_REQUEST != null && !empty($_REQUEST['product_id'])) ? $_REQUEST['product_id'] : '';
		$type = ($_REQUEST != null && !empty($_REQUEST['type'])) ? $_REQUEST['type'] : '';

		if(!empty($technical_request_id)){
			$tr_bean = BeanFactory::getBean('TR_TechnicalRequests');
			$tr_list = $tr_bean->get_full_list("", "tr_technicalrequests.id = '{$technical_request_id}' and tr_technicalrequests.deleted = 0");
			
			if(count($tr_list) > 0)
			{
				$tr_bean = $tr_list[0];
				$result['data']['id'] = $tr_bean->id;
				$result['data']['resin_compound_type_c'] = array_key_exists($tr_bean->resin_compound_type_c, $app_list_strings['resin_type_list']) ? 
					array('key' => $tr_bean->resin_compound_type_c, 'value' => $app_list_strings['resin_type_list'][$tr_bean->resin_compound_type_c]) : array();

				$result['data']['color_c'] = array_key_exists($tr_bean->color_c, $app_list_strings['pi_color_list']) ? 
					array('key' => $tr_bean->color_c, 'value' => $app_list_strings['pi_color_list'][$tr_bean->color_c]) : array();

				$result['data']['cm_product_form_c'] = array_key_exists($tr_bean->cm_product_form_c, $app_list_strings['cm_product_form_list']) ? 
					array('key' => $tr_bean->cm_product_form_c, 'value' => $app_list_strings['cm_product_form_list'][$tr_bean->cm_product_form_c]) : array();

				$result['data']['fda_food_contact_c'] = array_key_exists($tr_bean->fda_food_contact_c, $app_list_strings['fda_food_contact_list']) ? 
					array('key' => $tr_bean->fda_food_contact_c, 'value' => $app_list_strings['fda_food_contact_list'][$tr_bean->fda_food_contact_c]) : array();

				$application = '';
				if(empty($product_id)){
					$application  = $tr_bean->application_c;
				}
				$result['data']['technical_request']['application'] = $application;

				$result['success'] = true;

				//For Products
				$tr_bean->load_relationship('tr_technicalrequests_aos_products_2');
				$product_list = $tr_bean->tr_technicalrequests_aos_products_2->getBeans();
				$is_allow_production = true;

				if(count($product_list) > 0)
				{
					$products = array();
					$dev_not_allowed_statuses = array('in_process', 'approved');

					foreach($product_list as $product_bean)
					{
						if($product_bean->id != $product_id && $type == 'production' && $product_bean->status_c == 'active')
						{
							$is_allow_production = false;
						}
					}
				}

				$result['products']['is_allow_production'] = $is_allow_production;

				//For TR Market
				$result['data']['technical_request']['market_id'] = $tr_bean->mkt_markets_id_c;
				$result['data']['technical_request']['market_name'] = $tr_bean->market_c;

				$result['data']['technical_request']['name'] = $tr_bean->name ?? '';
				$result['data']['technical_request']['site'] = $tr_bean->site ?? '';
			}
			// For Product Category
			$result['data']['technical_request']['product_category_c'] = $tr_bean->product_category_c;

			//Colormatch #294 - Due Date
			$dueDate = new DateTime($tr_bean->req_completion_date_c);
			$formattedDueDate = $dueDate->format($userDateFormat);
			$result['data']['technical_request']['due_date_c'] = $formattedDueDate;
			
			$result['data']['technical_request']['target_letdown_c'] = $tr_bean->target_letdown_c;
		}
        
        echo json_encode($result);
	}

    public function action_get_number_sequencer_old()
    {
		global $log;
		// $log->fatal('action_get_number_sequencer');

		$result = array('success' => false, 'data' => array());
		// $base_resin = ($_POST != null && !empty($_POST['base_resin'])) ? $_POST['base_resin'] : '';
		// $color = ($_POST != null && !empty($_POST['color'])) ? $_POST['color'] : '';
		// $cm_product_form = ($_POST != null && !empty($_POST['cm_product_form'])) ? $_POST['cm_product_form'] : '';
		// $carrier_resin = ($_POST != null && !empty($_POST['carrier_resin'])) ? $_POST['carrier_resin'] : '';
		// $fda_eu_food_contract = ($_POST != null && !empty($_POST['fda_eu_food_contract'])) ? $_POST['fda_eu_food_contract'] : '';

		$base_resin = (isset($_REQUEST['base_resin'])) ? $_REQUEST['base_resin'] : '';
		$color = (isset($_REQUEST['color'])) ? $_REQUEST['color'] : '';
		$cm_product_form = (isset($_REQUEST['cm_product_form'])) ? $_REQUEST['cm_product_form'] : '';
		$carrier_resin = (isset($_REQUEST['carrier_resin'])) ? $_REQUEST['carrier_resin'] : '';
		$fda_eu_food_contract = (isset($_REQUEST['fda_eu_food_contract'])) ? $_REQUEST['fda_eu_food_contract'] : '';

		if(!empty($base_resin) && !empty($color))
		{
			$sequence = '';
			$base_resin_and_color = $base_resin . $color;
			// $log->fatal("base_resin_and_color: " . $base_resin_and_color);
			$sequences = ProductHelper::get_number_sequencer($base_resin_and_color);
			$sequences_count = count($sequences);

			if($sequences_count > 0){
				$sequence = str_pad(($sequences_count + 1), 4, '0', STR_PAD_LEFT);
			}
			else
			{
				$sequence = '0001';
			}

			$result['data']['initial_sequence'] = $sequence;
			$result['success'] = true;
		}

		echo json_encode($result);
	}

	public function action_get_site_list()
	{
		global $log;

		$result = array('success' => false, 'data' => array());
	
		$site = $_POST['site'];

		if(!empty($site))
		{
			$result = ProductHelper::get_site_coordinator($site);
		}
	
		echo json_encode($result);
	}

	//OnTrack #953
	public function action_get_aos_product(){
		$result = array('success' => false, 'data' => array());
		$product_id = (isset($_REQUEST['product_id'])) ? $_REQUEST['product_id'] : '';

		if(!empty($product_id)){
			$product_bean = BeanFactory::getBean('AOS_Products', $product_id);

			if(!empty($product_bean->id)){
				$result['success'] = true;
				$result['data']['product_id'] = $product_bean->id;
				$result['data']['base_resin_c'] = $product_bean->base_resin_c;
				$result['data']['color_c'] = $product_bean->base_resin_c;
				$result['data']['geometry_c'] = $product_bean->geometry_c;
				$result['data']['fda_eu_food_contract_c'] = $product_bean->fda_eu_food_contract_c;
				$result['data']['resin_type_c'] = $product_bean->resin_type_c;//resin_type_c
			}
		}

		echo json_encode($result);
    }
    // APX Custom Codes -- END
}