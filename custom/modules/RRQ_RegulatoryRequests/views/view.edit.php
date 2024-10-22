<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');
require_once('custom/modules/RRQ_RegulatoryRequests/helpers/RRQ_RegulatoryRequestsHelper.php');
require_once('custom/modules/RRWG_RRWorkingGroup/helpers/RRWorkingGroupHelper.php');

class RRQ_RegulatoryRequestsViewEdit extends ViewEdit {

    function __construct(){
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function TR_TechnicalRequestsViewEdit() {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    public function preDisplay(){
        $metadataFile = $this->getMetaDataFile();
        
        $this->ev = $this->getEditView();
        $this->ev->ss =& $this->ss;
        // $this->ev->setup($this->module, $this->bean, $metadataFile, 'custom/modules/RRQ_RegulatoryRequests/EditView.tpl');
        parent::preDisplay();
    }

    function display() 
    {
        global $log, $current_user;

        $this->bean->id_num_c = (!$this->bean->id) ? 'TBD' : $this->bean->id_num_c;
        $this->bean->submit_by_c = (!$this->bean->id) ? 'TBD' : $this->bean->submit_by_c;
        $this->bean->assigned_user_name = (!$this->bean->id) ? '' : $this->bean->assigned_user_name;
        $this->bean->status_update_c = "";
        $isEditableAssignedTo = false;

        //$customer_prod_data = RRQ_RegulatoryRequestsHelper::get_customer_products_data();
        //$customer_prod_data_count = RRQ_RegulatoryRequestsHelper::get_customer_products_data_count();


        $this->SubmitForReview();
        // Define a separate Smarty object for the custom HTML divs: Add More Button and Customer Products dynamic fields and Customer Products select Pop-up
        $smarty = new Sugar_Smarty();
        $smarty->assign('CUSTOMER_PRODUCTS_ROWS_HTML', RRQ_RegulatoryRequestsHelper::get_customer_product_rows($this->bean->id));
        $smarty->assign('CUSTOMER_PRODUCTS_MODAL_TEMPLATE_HTML', RRQ_RegulatoryRequestsHelper::get_customer_product_modal_html());
        $smarty->assign('CUSTOMER_PRODUCTS_ROWS_TEMPLATE_HTML', RRQ_RegulatoryRequestsHelper::get_customer_product_rows_html());
        $smarty->assign('CUSTOMER_PRODUCTS_DATA', $this->get_customer_products());


        // $addMoreButton = $smarty->fetch('custom/modules/RRQ_RegulatoryRequests/includes/addmorebutton.tpl');
        $customCustomerProductFields = $smarty->fetch('custom/modules/RRQ_RegulatoryRequests/includes/customer-product-fields.tpl');        
        
        // Make Assigned To field editable if Current logged user is the Regulatory Manager or is an Admin
        if (RRQ_RegulatoryRequestsHelper::isRegulatoryManager($this->bean) || $current_user->is_admin) {
            $isEditableAssignedTo = true;
        }

        // OnTrack #1793: Editable Assigned To field if logged user has a Regulatory Role (not an admin and not the Regulatory Manager)
        if (RRQ_RegulatoryRequestsHelper::isRegulatoryUser($this->bean) && $this->bean->status_c == 'new' && ! ($current_user->is_admin || RRQ_RegulatoryRequestsHelper::isRegulatoryManager($this->bean))) {
            $isEditableAssignedTo = true;
        }
        
        
        // $this->ss->assign('ADD_MORE_BUTTON', $addMoreButton);
        $this->ss->assign('CUSTOMER_PRODUCTS_HTML', $customCustomerProductFields);
        $this->ss->assign('IS_EDITABLE_ASSIGNED_TO_FIELD', $isEditableAssignedTo);
        

        // TO DO: Check if this is depracated: used in Custom EditView.tpl for RRQ_RegulatoryRequests
        if($this->bean->status_c == 'draft'){
            $this->ss->assign('showSubmitForReview', false);
        }

        // $this->manage_statuses();
        
        if (isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Accounts' && $_REQUEST['return_action'] == 'DetailView') {
            // When it's from RRQ Subpanel Create from Accounts, override account id to the account's parent id when Account Type == 'Customer'
            $accountBean = BeanFactory::getBean('Accounts', $_REQUEST['account_id']);
            
            if ($accountBean->account_type == 'Customer') {
                // Used hidden fields from Account -> Reg Request Create button to determine which fields to modify
                $_REQUEST['accounts_rrq_regulatoryrequests_1_name'] = $accountBean->parent_name;
                $_REQUEST['accounts_rrq_regulatoryrequests_1accounts_ida'] = $accountBean->parent_id;
            }

            // Need to modify redirect to Reg Req Detail View to not confuse users why data is not in subpanel of child account
            $_REQUEST['return_module'] = $this->bean->module_dir;
            $_REQUEST['return_id'] = $this->bean->id;
        }
        
        parent::display();
        echo $this->appendJS();

        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/RRQ_RegulatoryRequests/js/edit.js?v={$guid}'></script>";
    }

    //filter the allowed statuses according to current status
    private function manage_statuses(){
        global $app_list_strings, $current_user;

        //var_dump($this->bean->status_c);

        if(!$this->bean->status_c){
            $app_list_strings['reg_req_statuses'] = array('draft' => 'Draft');
        }
        else if($this->bean->status_c == 'draft'){
            $app_list_strings['reg_req_statuses'] = array(
                'draft' => 'Draft',
                'new' => '0 – New'
            );
        }
        else if($this->bean->status_c == 'new'){
            if(isset($_POST['is_submit_for_review']) && $_POST['is_submit_for_review'] == 'true'){
                $app_list_strings['reg_req_statuses'] = array('new' => '0 – New');
            }
            else{
                $app_list_strings['reg_req_statuses'] = array(
                    'new' => '0 – New',
                    'awaiting_more_info' => 'Awaiting More Info',
                    'rejected' => 'Rejected',
                    'created_in_error' => 'Created In Error',
                );

                $this->bean->assigned_user_name = '';
                $this->bean->assigned_user_id = '';
            }
        }
        else if($this->bean->status_c == 'assigned'){
            $app_list_strings['reg_req_statuses'] = array(
                'assigned' => '1 - Assigned',
                'in_process' => '2 - In Process',
                'awaiting_more_info' => 'Awaiting More Info',
                'rejected' => 'Rejected',
            );

            $assigned_to_user = '';
            // if($current_user->id == $this->bean->assigned_user_id){
            //     $app_list_strings['reg_req_statuses']['complete'] = '3 - Complete';
            // }
        }
        else if($this->bean->status_c == 'draft'){
            $app_list_strings['reg_req_statuses'] = array(
                'draft' => 'Draft',
                'awaiting_more_info' => 'Awaiting More Info',
                'rejected' => 'Rejected',
            );
        }
        else if($this->bean->status_c == 'in_process'){
            $app_list_strings['reg_req_statuses'] = array(
                'in_process' => '2 - In Process',
                'complete' => '3 - Complete',
                'awaiting_more_info' => 'Awaiting More Info',
                'rejected' => 'Rejected',
            );
        }
        else if($this->bean->status_c == 'complete'){
            $app_list_strings['reg_req_statuses'] = array(
                'in_process' => '2 - In Process',
                'complete' => '3 - Complete',
            );
        }
        
    }

    private function get_customer_products() {
        global $app_list_strings, $log;

        $industryDom = $app_list_strings['industry_dom'];
        $result = array();
        $this->bean->load_relationship('rrq_regulatoryrequests_ci_customeritems_2');
        $db_cust_prod_bean_list = $this->bean->rrq_regulatoryrequests_ci_customeritems_2->getBeans();
        foreach($db_cust_prod_bean_list as $db_cust_prod_bean){
            $result[$db_cust_prod_bean->id] = array(
                'id' => $db_cust_prod_bean->id,
                'name' => $db_cust_prod_bean->name,
                'product_number_c' => $db_cust_prod_bean->product_number_c,
                'version_c' => $db_cust_prod_bean->version_c,
                'application_c' => $db_cust_prod_bean->application_c,
                'oem_account_c' => $db_cust_prod_bean->oem_account_c,
                // 'industry_c' => $db_cust_prod_bean->industry_c
                'industry_c' => $industryDom[$db_cust_prod_bean->industry_c]
            );
        }
        
        return json_encode($result);
    }

    private function SubmitForReview($regulatoryManager = null){
        $is_submit_for_review = 'false';

        if(isset($_POST['is_submit_for_review']) && $_POST['is_submit_for_review'] == 'true')
        {
            $fields_not_to_copy = array('status');

            $reg_req_request_bean = BeanFactory::getBean('RRQ_RegulatoryRequests', $_POST['reg_req_request_id']);
            
            foreach (get_object_vars($reg_req_request_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    $this->bean->$key = $value;
                }
            }

            // Regulatory Manager Bean
            $regulatoryManagerUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($this->bean, 'RegulatoryManager');

            // Regulatory Analyst Bean
            $regulatoryAnalystUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($this->bean, 'RegulatoryAnalyst');

            $this->bean->status_c = ($regulatoryAnalystUserBean && $regulatoryAnalystUserBean->id) 
                ? 'assigned'
                : 'new';

            if ($this->bean->status_c == 'assigned') {
                if ($regulatoryAnalystUserBean && $regulatoryAnalystUserBean->id) {
                    $this->bean->assigned_user_id = $regulatoryAnalystUserBean->id;
                    $this->bean->assigned_user_name = $regulatoryAnalystUserBean->name;    
                }
            } else if ($this->bean->status_c == 'new') {
                if ($regulatoryManagerUserBean && $regulatoryManagerUserBean->id) {
                    $this->bean->assigned_user_id = $regulatoryManagerUserBean->id;
                    $this->bean->assigned_user_name = $regulatoryManagerUserBean->name;
                }
            }

            $is_submit_for_review = 'true';
        }

        echo <<<EOD
            <script type="text/javascript">
                var is_submit_for_review = {$is_submit_for_review};
            </script>
EOD;
    }

    private function appendJS(){
        global $app_list_strings;

        $db_status = !empty($this->bean->id) ? $this->bean->status_c : '';
        $industry_dom = json_encode($app_list_strings['industry_dom']);

        return <<<EOD
            <style>
                .cstm-error-block {
                    border: 1px solid red;
                    padding-top: 5px;
                }
                div[data-label=LBL_CUSTOMER_PRODUCTS_ADD_MORE_BUTTON_NON_DB], div[data-label=LBL_CUSTOMER_PRODUCTS_HTML] {
                    display: none !important;
                }
            </style>
            <script type="text/javascript">
            
                
                var assigned_user_obj = $('div[field="assigned_user_name"]');
                var assigned_user_val = assigned_user_obj.find('input[name="assigned_user_name"]').val();
                var db_status = '{$db_status}';
                var industry_dom = '{$industry_dom}';
                assigned_user_obj.append('<div id="assigned_user_name_label" style="display: none;">'+ assigned_user_val +'</div>');

                jQuery(function() {
                    var panel_bg_color = 'var(--custom-panel-bg)'; 
                    
                    jQuery("div[field='customer_products_panel_nondb']").prev()
                        .removeClass('col-sm-2')
                        .addClass('col-sm-12')
                        .addClass('col-md-12')
                        .addClass('col-lg-12')
                        .css('background-color', panel_bg_color)
                        .css('color', '#FFF').css('margin-top', '15px')
                        .css('padding', '5px 0px 13px 10px').parent()
                        .css('padding-left', '0px');
                    jQuery("div[field='customer_products_panel_nondb']").addClass('hidden');
                    jQuery("div[field=custom_customer_products_html], div[field=btn_add_customer_product]").removeClass('col-sm-8');
                });
              
            </script>
EOD;
    }
}
?>

