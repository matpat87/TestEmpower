<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

class TR_TechnicalRequestsViewEdit extends ViewEdit {
    private $is_rematch = false;
    private $safety_datasheet_html = '';

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


    function display() {
        global $app_list_strings, $timedate;
        $this->safety_datasheet_html = $this->GetSafetyDataSheetHTML();
        
        self::Duplicate();
        self::FromOpportunity();
        $this->SubmitForDevelopment();
        
        // TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
        if(!$this->is_rematch){
            $this->bean->technicalrequests_number_c = (! $this->bean->id) ? 'TBD' : TechnicalRequestHelper::assign_technicalrequests_number($this->bean->id);
        }
        $this->bean->avg_sell_price_c = NumberHelper::GetCurrencyValue($this->bean->avg_sell_price_c);
        $this->bean->price_c = NumberHelper::GetCurrencyValue($this->bean->price_c);
        $this->bean->annual_amount_c = NumberHelper::GetCurrencyValue($this->bean->annual_amount_c);
        $this->bean->annual_amount_weighted_c = NumberHelper::GetCurrencyValue($this->bean->annual_amount_weighted_c);

        if (!empty($this->bean->tr_technicalrequests_id_c)) {
            $relatedTechnicalRequest = BeanFactory::getBean('TR_TechnicalRequests', $this->bean->tr_technicalrequests_id_c);
            $this->bean->related_technical_request_c = TechnicalRequestHelper::get_related_tr_name($relatedTechnicalRequest);

        }


        if ($this->bean->type !== 'product_sample') {
            // If Product # (Customer Products) relate field is populated, set relate field name value as product_number_c instead of name
            if ($this->bean->ci_customeritems_tr_technicalrequests_1ci_customeritems_ida) {
                $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $this->bean->ci_customeritems_tr_technicalrequests_1ci_customeritems_ida);
                $this->bean->ci_customeritems_tr_technicalrequests_1_name = $customerProductBean->product_number_c;
            }
        } else {
            $productMasterBean = BeanFactory::getBean('AOS_Products')->retrieve_by_string_fields(
                array(
                    "product_number_c" => $this->bean->name,
                ), false, true
            );

            // If Product # (Product Master) relate field is populated, set relate field name value as product_number_c instead of name
            if ($productMasterBean && $productMasterBean->id) {
                $this->bean->tr_technicalrequests_aos_products_2aos_products_idb = $productMasterBean->id;
                $this->bean->tr_technicalrequests_aos_products_2_name = $productMasterBean->product_number_c;
            }
        }

        $this->AddCSS();
        $this->SortList();
        $this->ManageDistroTypes();
        $this->AddDefaults();

        $this->ss->assign('FILENAME', $this->safety_datasheet_html);
        $this->ss->assign('APPROVAL_STAGE', TechnicalRequestHelper::handle_stage_status_routing($this->bean->approval_stage, $this->bean->status, $this->bean->type));
        $this->ss->assign('DATE_ENTERED', date($timedate->getInstance()->get_date_format(), strtotime(handleRetrieveBeanDateEntered($this->bean))));

        parent::display();
        $this->AddSections();
        $this->AddJS();
    }

    private function AddDefaults()
    {
        $this->bean->technical_request_update = ''; //Colormatch #314

        if(TechnicalRequestHelper::is_id_exists($this->bean->id))
        {
            //Colormactch #243 - Assign Contact default value
            if(empty($this->bean->contact_id_c))
            {
                $this->bean->load_relationship('tr_technicalrequests_contacts_1');
                $contacts = $this->bean->tr_technicalrequests_contacts_1->getBeans();
                if(!empty($contacts) && count($contacts) > 0)
                {
                    $contact = array_values($contacts)[0];
                    $this->bean->contact_id_c = $contact->id;
                    $this->bean->contact_c = $contact->name;
                }
            }
        }
    }

    private function ManageDistroTypes()
    {
        global $app_list_strings;
        
        $distro_type_html = '';

        echo '<style>
            #opp_trs {
                width: 200px; height: 32px; margin-left: 5px;
            }
        </style>';
        if(! TechnicalRequestHelper::is_id_exists($this->bean->id) || ! $this->bean->distro_type_c){
            $opp_trs = TechnicalRequestHelper::get_opp_trs_with_distros($this->bean->tr_technicalrequests_opportunitiesopportunities_ida);
            $distro_type_list = (count($opp_trs) == 0) ? array('new' => 'New') : $app_list_strings['distro_type_list'];
            $distro_type_html = "<select name=\"distro_type_c\" id=\"distro_type_c\" style=\"width: 100px; height: 32px;\" data-options='". json_encode($app_list_strings['distro_type_list']) ."'>";

            foreach($distro_type_list as $dropdown_key => $dropdown_val)
            {
                $distro_type_selected = ($dropdown_key == $this->bean->distro_type_c) ? 'selected="selected"' : '';
                $distro_type_html .= '<option value="'. $dropdown_key .'" '. $distro_type_selected .'>'. $dropdown_val .'</option>';
            }

            $distro_type_html .= '</select>';

            $opp_trs_data = "data-options='" . json_encode($opp_trs) . "'";
            $distro_type_html .= '<select name="opp_trs" id="opp_trs" '. $opp_trs_data .'>';

            //Opportunity relationship
            if(!empty($opp_trs) && count($opp_trs) > 0)
            {
                foreach($opp_trs as $tr_id => $tr_name)
                {
                    $distro_type_html .= '<option value='. $tr_id .'>' . $tr_name .'</option>';
                }
            }

            $distro_type_html .= '</select>';

            $distro_type_html .= '<button type="button" id="btn_distro_list" class="button" style="margin-left: 5px; padding-left: 10px; padding-right: 10px; width: 32px;">
                <span class="glyphicon glyphicon-new-window"></span></button>';

            $distro_type_html .= '<div id="mdlDistributionList" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: bolder">Distro List</h5>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>';
        }
        else
        {
            $distro_type_html .= "<select class=\"custom-readonly\" name=\"distro_type_c\" id=\"distro_type_c\" style=\"width: 100px;\" disabled=\"disabled\">";
            $distro_type_html .= '<option value="'. $this->bean->distro_type_c .'">' . $app_list_strings['distro_type_list'][$this->bean->distro_type_c] . '</option>';
            $distro_type_html .= '</select>';
        }

        $this->ss->assign('DISTRO_TYPE_C', $distro_type_html);
    }

    private function SortList()
    {
        global $app_list_strings;

        asort($app_list_strings['pi_color_list']);
        customResinTypeSortedList(); // Called from custom_utils.php
    }

    private function FromOpportunity()
    {
        if(isset($_POST['return_module']) && $_POST['return_module'] == 'Opportunities'
            && isset($_POST['account_id']) && !empty($_POST['account_id']))
        {
            $account_bean = BeanFactory::getBean('Accounts', $_POST['account_id']);
            $this->bean->tr_technicalrequests_accounts_name = $account_bean->name;
            $this->bean->tr_technicalrequests_accountsaccounts_ida = $account_bean->id;
        }

        //if Request come from Opportunities
        if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Opportunities'
            && isset($_REQUEST['return_id']) && !empty($_REQUEST['return_id']))
        {
            $opportunity_bean = BeanFactory::getBean('Opportunities', $_REQUEST['return_id']);
            $this->bean->tr_technicalrequests_opportunitiesopportunities_ida = $opportunity_bean->id;
            $this->bean->tr_technicalrequests_opportunities_name = $opportunity_bean->name;

            if(!empty($opportunity_bean->account_id)){
                $account_bean = BeanFactory::getBean('Accounts', $opportunity_bean->account_id);

                $this->bean->tr_technicalrequests_accounts_name = $account_bean->name;
                $this->bean->tr_technicalrequests_accountsaccounts_ida = $account_bean->id;
            }

            //Markets
            $opportunity_bean->load_relationship('mkt_markets_opportunities_1');
            $opp_markets = $opportunity_bean->mkt_markets_opportunities_1->getBeans();
            if(count($opp_markets) > 0)
            {
                $market = reset($opp_markets);
                $this->bean->market_c = $market->name;
                $this->bean->mkt_markets_id_c = $market->id;
            }
        }
    }

    private function Duplicate()
    {
        $is_rematch = false;

        if(isset($_POST['is_copy_partial']) && $_POST['is_copy_partial'] == 'true')
        {
            $fields_to_copy = array('name', 'type', 
                'status', 'tr_technicalrequests_opportunities_name', 'tr_technicalrequests_opportunitiesopportunities_ida',
                'tr_technicalrequests_accounts_name', 'tr_technicalrequests_accountsaccounts_ida', 'site',
                'scheduling_code_c', 'application_c',
                'special_instructions_c', 'complexity_c',
                'technical_request_update', 'priority_level_c', 'contact_c', 'contact_id1_c');

            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['technical_request_id']);

            foreach (get_object_vars($technical_request_bean) as $key => $value) {
                if(in_array($key, $fields_to_copy))
                {
                    // Ontrack 1995: If site is Asheboro/Delaware, then set it to empty.
                    if ($key == 'site' && in_array($value, array_keys($GLOBALS['app_list_strings']['excluded_site_list']))) {
                        $this->bean->$key = '';
                    } else {
                        $this->bean->$key = $value;
                    }
                }
            }

            $this->bean->approval_stage = 'new';
            $this->bean->custom_rematch_type = 'copy_partial';
        }

        // if(isset($_POST['isDuplicate']) && $_POST['isDuplicate'] == 'true')
        // {
        //     $fields_not_to_copy = array('id', 'avg_sell_price_c', 'annual_volume_c', 'annual_amount_c',
        //         'technical_request_update', 'approval_stage');

        //     $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['return_id']);

        //     foreach (get_object_vars($technical_request_bean) as $key => $value) {
        //         if(in_array($key, $fields_not_to_copy))
        //         {
        //             $this->bean->$key = '';
        //         }
        //     }

        //     $this->bean->custom_rematch_type = 'copy_full';
        //     $this->bean->tr_technicalrequests_id_c = $technical_request_bean->id;
        //     $this->bean->related_technical_request_c = $technical_request_bean->name;
        //     $this->bean->related_technical_request_c = TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
        //     $this->bean->version_c = str_pad('1', 2, '0', STR_PAD_LEFT);
        // }

        //For Copy Full
        if(isset($_POST['is_copy_full']) && $_POST['is_copy_full'] == 'true')
        {
            $fields_not_to_copy = array(
                'id', 'avg_sell_price_c', 'annual_volume_c', 'annual_amount_c',
                'technical_request_update', 'approval_stage', 'created_by_name',
                'date_entered', 'distro_type_c', 'color_c', 
                'assigned_user_name', 'assigned_user_id', 
                'tr_technicalrequests_id_c', 'related_technical_request_c',
                'actual_close_date_c', 'req_completion_date_c', 'est_completion_date_c', 'resin_compound_type_c'
            );

            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['technical_request_id']);

            foreach (get_object_vars($technical_request_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    // Ontrack 1995: If site is Asheboro/Delaware, then set it to empty.
                    if ($key == 'site' && in_array($value, array_keys($GLOBALS['app_list_strings']['excluded_site_list']))) {
                        $this->bean->$key = '';
                    } else {
                        $this->bean->$key = $value;
                    }
                }
            }

            $this->bean->custom_rematch_type = 'copy_full';
            $this->bean->custom_reference_tr_id_nondb = $_POST['technical_request_id'];
            // $this->bean->tr_technicalrequests_id_c = $technical_request_bean->id;
            // $this->bean->related_technical_request_c = $technical_request_bean->name;
            // $this->bean->related_technical_request_c = TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
            $this->bean->version_c = str_pad('1', 2, '0', STR_PAD_LEFT);

            //Colormatch #272
            // $technical_request_bean->load_relationship('tr_technicalrequests_documents');
            // $documents = $technical_request_bean->tr_technicalrequests_documents->getBeans(); 
            // if(count($documents) > 0)
            // {
            //     $document = array_values($documents)[0];
            //     $this->safety_datasheet_html = '<div id="sdsEditContainer" style="display: none;">' . $this->safety_datasheet_html . '</div>';
            //     $this->safety_datasheet_html .= '<div id="sdsDetailContainer"><a target="_blank" href="index.php?entryPoint=download&id='. $document->id .'&type=Documents"">' . $document->name . '</a><a id="removeSDS" href="#" class="pull-right" title="Remove Safety Data Sheet"><i class="glyphicon glyphicon-remove"></i></a><input type="hidden" id="sdsDocumentID" name="sdsDocumentID" value="'. $document->id .'" /></div>';
            // }
        }

        //For Rematch Version
        if(isset($_POST['is_rematch_version']) && $_POST['is_rematch_version'] == 'true')
        {
            $fields_not_to_copy = array('avg_sell_price_c', 'annual_volume_c', 'annual_amount_c',
                'technical_request_update', 'approval_stage', 'id', 'req_completion_date_c', 'est_completion_date_c',
                'tr_technicalrequests_id_c', 'related_technical_request_c', 'distro_type_c', 'assigned_user_name', 'assigned_user_id', 'created_by_name', 'date_entered');


            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['technical_request_id']);
            
            global $log;
            foreach (get_object_vars($technical_request_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    // Ontrack 1995: If site is Asheboro/Delaware, then set it to empty.
                    if ($key == 'site' && in_array($value, array_keys($GLOBALS['app_list_strings']['excluded_site_list']))) {
                        $this->bean->$key = '';
                    } else {
                        $this->bean->$key = $value;
                    }
                }
            }

            $this->bean->technicalrequests_number_c = $technical_request_bean->technicalrequests_number_c;
            $this->bean->tr_technicalrequests_id_c = $technical_request_bean->id;
            $this->bean->related_technical_request_c = TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
            $this->bean->custom_rematch_type = 'rematch_version';
            //$version = (!empty($technical_request_bean->version_c)) ? (intval($technical_request_bean->version_c) + 1) : '1';
            $this->bean->version_c = str_pad(TechnicalRequestHelper::get_version($technical_request_bean->technicalrequests_number_c), 2, '0', STR_PAD_LEFT);
            $this->bean->custom_rematch_original_tr = $technical_request_bean->id;

            $this->is_rematch = true;
        }

        //For Rematch Rejected
        if(isset($_POST['is_rematch_rejected']) && $_POST['is_rematch_rejected'] == 'true')
        {
            $fields_not_to_copy = array('avg_sell_price_c', 'annual_volume_c', 'annual_amount_c',
                'technical_request_update', 'approval_stage', 'id', 'req_completion_date_c', 'est_completion_date_c',
                'tr_technicalrequests_id_c', 'related_technical_request_c', 'distro_type_c', 'assigned_user_name', 'assigned_user_id', 'created_by_name', 'date_entered');


            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['technical_request_id']);
            

            foreach (get_object_vars($technical_request_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    // Ontrack 1995: If site is Asheboro/Delaware, then set it to empty.
                    if ($key == 'site' && in_array($value, array_keys($GLOBALS['app_list_strings']['excluded_site_list']))) {
                        $this->bean->$key = '';
                    } else {
                        $this->bean->$key = $value;
                    }
                }
            }

            $this->bean->technicalrequests_number_c = $technical_request_bean->technicalrequests_number_c;
            $this->bean->tr_technicalrequests_id_c = $technical_request_bean->id;
            $this->bean->related_technical_request_c = TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
            $this->bean->custom_rematch_type = 'rematch_rejected';
            //$version = (!empty($technical_request_bean->version_c)) ? (intval($technical_request_bean->version_c) + 1) : '1';
            $this->bean->version_c = str_pad(TechnicalRequestHelper::get_version($technical_request_bean->technicalrequests_number_c), 2, '0', STR_PAD_LEFT);
            $this->bean->custom_rematch_original_tr = $technical_request_bean->id;

            $this->is_rematch = true;
        }

        // For production rematch
        if(isset($_POST['is_production_rematch']) && $_POST['is_production_rematch'] == 'true')
        {
            $fields_not_to_copy = array('id', 'avg_sell_price_c', 'annual_volume_c', 'annual_amount_c',
                'technical_request_update', 'approval_stage', 'created_by_name',
                'date_entered', 'distro_type_c', 'color_c', 'assigned_user_name', 'assigned_user_id', 'colormatch_type_c');

            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['technical_request_id']);

            foreach (get_object_vars($technical_request_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    $this->bean->$key = $value;
                }
            }

            $this->bean->custom_rematch_type = 'production_rematch';
            $this->bean->tr_technicalrequests_id_c = $technical_request_bean->id;
            $this->bean->related_technical_request_c = $technical_request_bean->name;
            $this->bean->related_technical_request_c = TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
            $this->bean->version_c = str_pad('1', 2, '0', STR_PAD_LEFT);
            $this->bean->type = 'rematch';

            //Colormatch #272
            $technical_request_bean->load_relationship('tr_technicalrequests_documents');
            $documents = $technical_request_bean->tr_technicalrequests_documents->getBeans(); 
            if(count($documents) > 0)
            {
                $document = array_values($documents)[0];
                $this->safety_datasheet_html = '<div id="sdsEditContainer" style="display: none;">' . $this->safety_datasheet_html . '</div>';
                $this->safety_datasheet_html .= '<div id="sdsDetailContainer"><a target="_blank" href="index.php?entryPoint=download&id='. $document->id .'&type=Documents"">' . $document->name . '</a><a id="removeSDS" href="#" class="pull-right" title="Remove Safety Data Sheet"><i class="glyphicon glyphicon-remove"></i></a><input type="hidden" id="sdsDocumentID" name="sdsDocumentID" value="'. $document->id .'" /></div>';
            }
        }
    }

    //OnTrack 671 - Submit For Development
    private function SubmitForDevelopment(){
        if(isset($_POST['is_submit_for_development']) && $_POST['is_submit_for_development'] == 'true')
        {
            $fields_not_to_copy = array('approval_stage', 'status');

            $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $_POST['technical_request_id']);
            
            foreach (get_object_vars($technical_request_bean) as $key => $value) {
                if(!in_array($key, $fields_not_to_copy))
                {
                    $this->bean->$key = $value;
                }
            }

            $this->bean->approval_stage = 'development';
            $this->bean->status = 'new';
            $this->bean->probability_c = TechnicalRequestHelper::get_tr_probability_percentage($this->bean->approval_stage);
        }
    }

    private function AddSections()
    {
        $fields_js = "div[field='product_information_non_db'], div[field='custom_competitor_information_label_non_db'], div[field='custom_resin_info_concentrate_label_non_db'], ";
        $fields_js .= "div[field='custom_customer_base_label_non_db'], div[field='custom_stability_label_non_db'], div[field='custom_opacity_texture_label_non_db'], div[field='custom_tolerance_label_non_db'], ";
        $fields_js .= "div[field='custom_additives_label_non_db'], div[field='custom_special_testing_label_non_db'], div[field='custom_fda_label_non_db']";
        $fields_js .= ",div[field='product_information_panel_non_db'], div[field='physical_material_properties_panel_non_db'], div[field='customer_certifications_panel_non_db']";

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
                    
                $(\"$fields_js\")
                    .prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 8px 10px').parent().css('padding-left', '0px');

                $(\"$fields_js\")
                    .prev().css('margin-top', '0px');

                $(\"$fields_js\")
                    .addClass('hidden');

                //$('.panel-default').hide();
			});
		</script>";
    }

    private function AddCSS()
    {
        echo '<link rel="stylesheet" type="text/css" href="custom/modules/TR_TechnicalRequests/css/edit.css" />';
    }

    private function AddJS()
    {
        global $current_user;

        $is_allow_opportunity_process = 'false';
        $tr_status = '';
        $tr_sales_stage = '';
        $tr_is_submit_to_dev = (isset($_POST['is_submit_for_development']) && $_POST['is_submit_for_development'] == 'true') ? 'true' : 'false'; //OnTrack 671 - Submit For Development

        if(!TechnicalRequestHelper::is_id_exists($this->bean->id))
        {
            $is_allow_opportunity_process = 'true';
        }
        else
        {
            $tr_status = $this->bean->status;
            $tr_sales_stage = $this->bean->approval_stage;
        }

        // If logged user is not an Admin
        if (! $current_user->is_admin) {
            // Disable Assigned To field and hide Select and Clear button
            echo "<script> 
                $('#assigned_user_name').addClass('custom-readonly').prop('disabled', true);
                $('#btn_assigned_user_name, #btn_clr_assigned_user_name').attr('hidden', true);
            </script>";

            // If new record, disable Stage and Status fields
            if (! $this->bean->id) {
                echo "<script> 
                    $('#approval_stage, #status').addClass('custom-readonly').prop('disabled', true);
                </script>";
            }
        }

        echo 
        "<script>
            var is_allow_opportunity_process = {$is_allow_opportunity_process};
            var tr_status = '{$tr_status}';
            var tr_sales_stage = '{$tr_sales_stage}';
            var tr_is_submit_to_dev = {$tr_is_submit_to_dev};
        </script>";

        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/TR_TechnicalRequests/js/edit.js?v={$guid}'></script>";
    }

    private function GetSafetyDataSheetHTML()
    {
        return <<<EOD
        <script type="text/javascript" src="cache/include/externalAPI.cache.js?v=1GLWaVId2psFdAh3QsKJyA"></script>
        <script type="text/javascript" src="include/SugarFields/Fields/File/SugarFieldFile.js?v=1GLWaVId2psFdAh3QsKJyA"></script>
        <input type="hidden" name="deleteAttachment" value="0">
        <input type="hidden" name="filename" id="filename" value="">
        <input type="hidden" name="doc_id" id="doc_id" value="">
        <input type="hidden" name="doc_url" id="doc_url" value="">
        <input type="hidden" name="filename_old_doctype" id="filename_old_doctype" value="">
        <span id="filename_old" style="display:none;">
        <a href="index.php?entryPoint=download&amp;id=&amp;type=TR_TechnicalRequests" class="tabDetailViewDFLink"></a>
        <input type="button" class="button" id="remove_button" value="Remove" onclick="SUGAR.field.file.deleteAttachment(&quot;filename&quot;,&quot;doc_type&quot;,this);">
        </span>
        <span id="filename_new" style="display:">
        <input type="hidden" name="filename_escaped">
        <input id="filename_file" name="filename_file" type="file" title="" size="30" maxlength="255">
        <span id="filename_externalApiSelector" style="display:none;">
        <br><h4 id="filename_externalApiLabel">
        <span id="filename_more"><img src="themes/default/images/advanced_search.gif?v=1GLWaVId2psFdAh3QsKJyA" width="8px" height="8px" align="baseline" border="0" alt=""></span>
        <span id="filename_less" style="display: none;"><img src="themes/default/images/basic_search.gif?v=1GLWaVId2psFdAh3QsKJyA" width="8px" height="8px" align="baseline" border="0" alt=""></span>
        File on External Source</h4>
        <span id="filename_remoteNameSpan" style="display: none;">
        <input type="text" class="sqsEnabled yui-ac-input" name="filename_remoteName" id="filename_remoteName" size="30" maxlength="255" autocomplete="off" value=""><div id="EditView_filename_remoteName_results" class="yui-ac-container"><div class="yui-ac-content" style="display: none;"><div class="yui-ac-hd" style="display: none;"></div><div class="yui-ac-bd"><ul><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li><li style="display: none;"></li></ul></div><div class="yui-ac-ft" style="display: none;"></div></div></div>
        <span class="id-ff multiple">
        <button type="button" name="filename_remoteSelectBtn" id="filename_remoteSelectBtn" tabindex="0" title="Select File" class="button firstChild" value="Select File" onclick="SUGAR.field.file.openPopup('filename'); return false;">
        <span class="suitepicon suitepicon-action-select"></span></button>
        <button type="button" name="filename_remoteClearBtn" id="filename_remoteClearBtn" tabindex="0" title="Clear" class="button lastChild" value="Clear" onclick="SUGAR.field.file.clearRemote('filename'); return false;">
        <span class="suitepicon suitepicon-action-clear"></span>
        </button>
        </span>
        </span>
        <div style="display: none;" id="filename_securityLevelBox">
        <b>Security: </b>
        <select name="filename_securityLevel" id="filename_securityLevel">
        </select>
        </div>
        <script type="text/javascript">
        YAHOO.util.Event.onDOMReady(function() {
        SUGAR.field.file.setupEapiShowHide("filename","doc_type","EditView");
        });
        
        if ( typeof(sqs_objects) == 'undefined' ) {
            sqs_objects = new Array;
        }
        
        sqs_objects["EditView_filename_remoteName"] = {
        "form":"EditView",
        "method":"externalApi",
        "api":"",
        "modules":["EAPM"],
        "field_list":["name", "id", "url", "id"],
        "populate_list":["filename_remoteName", "doc_id", "doc_url", "filename"],
        "required_list":["name"],
        "conditions":[],
        "no_match_text":"No Match"
        };
        
        if(typeof QSProcessedFieldsArray != 'undefined') {
            QSProcessedFieldsArray["EditView_filename_remoteName"] = false;
        }
        enableQS(false);
        </script>
        </span>
        </span>
EOD;
    }
}
?>
