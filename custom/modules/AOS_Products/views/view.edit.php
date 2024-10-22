<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/AOS_Products/helper/ProductHelper.php');

class AOS_ProductsViewEdit extends ViewEdit {
    function __construct(){
        parent::__construct();
    }

    function display() {
        global $app_list_strings;

        $this->AppendDefaults();
        $this->Duplicate();
        $this->Rematch();
        $this->SortList();

        parent::display();
        $this->AppendJSDefaultValues();
    }

    private function Duplicate()
    {
        if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true')
        {
            $fields_not_to_copy = array('status_c');

            $product_bean = BeanFactory::getBean('AOS_Products', $_POST['return_id']);

            foreach (get_object_vars($product_bean) as $key => $value) {
                if(in_array($key, $fields_not_to_copy))
                {
                    $this->bean->$key = '';
                }
            }

            $this->bean->id = '';
        }
        
    }

    private function SortList()
    {
        customResinTypeSortedList(); // Called from custom_utils.php
    }

    private function Rematch()
    {
        //For Rematch Version
        if(isset($_REQUEST['is_rematch']) && $_REQUEST['is_rematch'] == 'true') {
            if(in_array($_REQUEST['rematch'], ['Rematch Version', 'Rematch Rejected', 'Rematch Product', 'Color Match'])) {
                $fields_not_to_copy = array('id', 'status_c');

                $product_bean = BeanFactory::getBean('AOS_Products', $_POST['product_id']);
                $trBean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['tr_id']);
                
                foreach (get_object_vars($product_bean) as $key => $value) {
                    if(!in_array($key, $fields_not_to_copy)) {
                        
                        // if site is in excluded list, set it to empty (Ontrack 1995)
                        if ($key == 'site_c' && in_array($value, array_keys($GLOBALS['app_list_strings']['excluded_site_list']))) {
                            $this->bean->$key = '';
                        } else {
                            $this->bean->$key = $value;
                        }
                    }
                }

                if ($trBean) {
                    $this->bean->tr_technicalrequests_aos_products_2tr_technicalrequests_ida = $trBean->id;
                    $this->bean->tr_technicalrequests_aos_products_2_name = $trBean->name;

                    $this->bean->product_category_c = $trBean->product_category_c;
                    $this->bean->base_resin_c = $trBean->resin_compound_type_c;
                    $this->bean->color_c = $trBean->color_c;
                    $this->bean->geometry_c = $trBean->cm_product_form_c;
                    $this->bean->fda_eu_food_contract_c = $trBean->fda_food_contact_c;
                }
                
                $this->bean->type = 'development';
                $this->bean->status_c = 'new';

                switch ($_REQUEST['rematch']) {
                    case 'Rematch Version':
                        $this->bean->custom_rematch_type = 'rematch_version';
                        break;
                    case 'Rematch Rejected':
                        $this->bean->custom_rematch_type = 'rematch_rejected';
                        break;
                    case 'Rematch Product':
                        $this->bean->custom_rematch_type = 'rematch_product';
                        break;
                    case 'Color Match':
                        $this->bean->custom_rematch_type = 'color_match';
                        break;
                    default:
                        break;
                }

                if (! empty($_REQUEST['rematch'])) {
                    if (in_array($_REQUEST['rematch'], ['Rematch Version', 'Rematch Rejected'])) {
                        $this->bean->version_c = ProductHelper::get_version($this->bean->product_number_c);
                        $this->bean->product_number_c = $product_bean->product_number_c;
                        $this->bean->custom_related_product_id = $product_bean->id;
                        $this->bean->related_product_c = '';
                        $this->bean->aos_products_id_c = '';
                    } else if (in_array($_REQUEST['rematch'], ['Rematch Product', 'Color Match'])) {
                        $this->bean->version_c = append_zero(1, 2);
                        $this->bean->product_number_c = 'TBD';
                        $this->bean->related_product_c = ProductHelper::get_product_num_with_version($product_bean);
                        $this->bean->aos_products_id_c = $product_bean->id;
                    }
                }
            } else if($_REQUEST['rematch'] == 'Sample ReMatch') {
                $fields_not_to_copy = array('id', 'status_c', 'aos_products_id_c', 'related_product_c', 'related_product_number_c', 'type');

                $product_bean = BeanFactory::getBean('AOS_Products', $_POST['product_id']);

                foreach (get_object_vars($product_bean) as $key => $value) {
                    if(!in_array($key, $fields_not_to_copy)) {
                        // if site is in excluded list, set it to empty (Ontrack 1995)
                        if ($key == 'site_c' && in_array($value, array_keys($GLOBALS['app_list_strings']['excluded_site_list']))) {
                            $this->bean->$key = '';
                        } else {
                            $this->bean->$key = $value;
                        }
                    }
                }

                $this->bean->product_number_c = 'TBD';
            }
        }
    }

    private function AppendDefaults()
    {
        if(isset($_POST) && !empty($_POST['return_module']) && $_POST['return_module'] == 'TR_TechnicalRequests')
        {
            $technical_request_id = (!empty($_POST['return_id'])) ? $_POST['return_id'] : '';

            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $technical_request_id);
            $this->bean->site_c = (in_array($technical_request_bean->site_c, array_keys($GLOBALS['app_list_strings']['excluded_site_list']))) ? "" : $technical_request_bean->site_c;

            //For Accounts
            if(isset($technical_request_bean) && !empty($technical_request_bean->tr_technicalrequests_accountsaccounts_ida)){
                
                $account = BeanFactory::getBean('Accounts', $technical_request_bean->tr_technicalrequests_accountsaccounts_ida);
                $this->bean->account_c = $account->name;
                $this->bean->account_id_c = $account->id;
            }

            if(!empty($technical_request_bean->name))
            {
                $this->bean->name = $technical_request_bean->name;
                $this->bean->application_c = $technical_request_bean->application_c;
            }

            //For Markets
            if($technical_request_bean != null){
                $this->bean->market_c = $technical_request_bean->market_c;
                $this->bean->mkt_markets_id_c = $technical_request_bean->mkt_markets_id_c;
            }

            //Colormatch #297 - Due Date
            if(!empty($technical_request_bean->req_completion_date_c)){
                $this->bean->due_date_c = $technical_request_bean->req_completion_date_c;
            }
        }

        //For Rematch
        if(!ProductHelper::is_id_exists($this->bean->id) || (!empty($_POST['isDuplicate']) && $_POST['isDuplicate'] == 'true'))
        {
            $this->bean->product_number_c = 'TBD';
            $this->bean->version_c = ProductHelper::get_version($this->bean->product_number_c);
        }

        //If Edit
        if(ProductHelper::is_id_exists($this->bean->id))
        {
            //For Related Product
            if(!empty($this->bean->aos_products_id_c)){
                $product_bean = BeanFactory::getBean('AOS_Products', $this->bean->aos_products_id_c);
                $this->bean->related_product_c = ProductHelper::get_product_num_with_version($product_bean, true);
            }
            
        }
    }

    private function AppendJSDefaultValues()
    {
        global $mod_strings;

        $lbl_number_of_attempts = $mod_strings['LBL_NUMBER_OF_ATTEMPTS'];
        $lbl_number_of_hours = $mod_strings['LBL_NUMBER_OF_HOURS'];

        $aos_product_id = '';
        $status_c = 'new';
        $is_allow_process = 'false';
        $is_allow_process_for_rematch = 'true';

        if(ProductHelper::is_id_exists($this->bean->id))
        {
            $aos_product_id = ((empty($_POST['isDuplicate']) || (!empty($_POST['isDuplicate']) && $_POST['isDuplicate'] == 'false')) && !empty($this->bean->id)) ? $this->bean->id : '';
            $status_c = $this->bean->status_c;
        }

        if(!ProductHelper::is_id_exists($this->bean->id) || (!empty($_POST['isDuplicate']) && $_POST['isDuplicate'] == 'true'))
        {
            $is_allow_process = 'true';
        }

        if(isset($this->bean->custom_rematch_type) && ($this->bean->custom_rematch_type == 'rematch_version' || $this->bean->custom_rematch_type == 'rematch_rejected'))
        {
            //echo 'yeah';
            $is_allow_process_for_rematch = 'false';
        }

        // When an existing record is to be edited, hide non-db "Technical Request" field 
		if (isset($this->bean->id)) {
			echo "
			<script>
				$(document).ready(function() {
					$(\"div[field='tr_technicalrequests_aos_products_2_name']\").parent().hide();
				});
			</script>";
        }
        
        echo 
        "<script>
            var status_c = '{$status_c}';
            var aos_product_id = '{$aos_product_id}';
            var is_allow_process = {$is_allow_process};
            var lbl_number_of_attempts = '{$lbl_number_of_attempts}';
            var lbl_number_of_hours = '{$lbl_number_of_hours}';
            var is_allow_process_for_rematch = {$is_allow_process_for_rematch};
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

            $(document).ready(function(){
                
            });
        </script>";

        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/AOS_Products/js/edit.js?v={$guid}'></script>";
    }
}
?>
