<?php

require_once('include/MVC/View/views/view.detail.php');
require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');

class CasesViewDetail extends ViewDetail {

	function __construct(){
        parent::__construct();
    }

    function preDisplay()
    {
        global $log;
        
        
        parent::preDisplay();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function CasesViewDetail(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


	function display() 
    {
        global $log, $current_user, $app_list_strings;
        
        $displayVerifyBtn = false;
        $customerItemBean = BeanFactory::getBean('CI_CustomerItems', $this->bean->ci_customeritems_cases_1ci_customeritems_ida);
        $this->bean->ci_customeritems_cases_1_name = $customerItemBean->product_number_c;

        $this->bean->actual_hours_non_db = retrieveActualHours($this->bean->id, $this->bean->module_name);
        $this->bean->status_update_log_c =  htmlspecialchars_decode($this->bean->status_update_log_c);
        
        // checks if the logged user has a role of Internal Auditor
        $isInternalAuditor = $this->checkLoggedUserRole('InternalAuditor');
        
        // Checks if all related Preventive Actions are of status = Closed 
        $completePreventiveActions = CustomerIssuesHelper::checkPreventiveActions($this->bean);

        // Set custom style for Status Field when status is Draft: font-color: amber
        $statusText = $app_list_strings['status_list'][$this->bean->status];
        $status = ($this->bean->status == 'Draft') 
            ? "<b style='color: #fd7403; text-transform:uppercase;'>{$statusText}</b>"
            : "<span>{$statusText}</span>";

        $this->ss->assign('CUSTOM_STATUS_DISPLAY', $status ?? '');


        $displayVerifyBtn = ($isInternalAuditor == true && $completePreventiveActions == true) ? 'display: inline-block' : 'display: none';
        
        $this->ss->assign('CUSTOMER_ISSUE_ID', $this->bean->id);
        $this->ss->assign('DISPLAY', $displayVerifyBtn);

        // Hide or Display "Quality Alert" option in Action items -- Ontrack #1891
        $dispayWhenStatusInArr = ['Approved', 'InProcess', 'CAPAReview', 'CAPAApproved', 'CAPAComplete'];
        $displayQualityAlertOption = in_array($this->bean->status, $dispayWhenStatusInArr);
        $displayDispositionFormOption = (!empty($this->bean->return_authorization_number_c)) && (!empty($this->bean->internal_material_dispo_c)); // Show 'Disposition Form when Return Authorized By AND Internal Material Disposition fields have values

        $this->ss->assign('SHOW_QUALITY_ALERT', $displayQualityAlertOption);
        $this->ss->assign('SHOW_DISPOSITION_FORM', $displayDispositionFormOption);
        
        // Show CAPA Report action item when Status is 'CAPAApproved', 'CAPAComplete', 'Closed', or 'Rejected'
        if (! in_array($this->bean->status, array('CAPAApproved', 'CAPAComplete', 'Closed', 'Rejected'))) {
           echo "<style>
                .custom-hide-btn {
                    display: none;
                }

                
           </style>";
        }
        // Do not allow creating Preventive Action if status is CAPA Approved, CAPA Complete or Closed
        if (in_array($this->bean->status, array('CAPAApproved', 'CAPAComplete', 'Closed'))) {
           echo "<style> #subpanel_cases_pa_preventiveactions_1 ul.clickMenu.fancymenu.SugarActionMenu li:first-child { display: none; } </style>";
        }

        // Hide tabs except Issue when Status == Draft
        if ($this->bean->status == 'Draft') {
            echo "<style>
                .detail-view ul.nav.nav-tabs li[role=presentation]:not(:first-child) {
                    display: none !important;
                }
            </style>";
        }

        
		parent::display();

       
        

        // Hide input fields so that custom non-db fields will display labels only
        // Added by: Ralph Julian Siasat
        echo "
        <style>
        #status_update_log_c, #description {
            height: 200px;
            line-height: 20px;
            display: block;
            padding-top: 5px;
            overflow-y:scroll;
        }

        #verified_status_c_btn {
            font-size: 0.85em;
            {$displayVerifyBtn};
        }

        #status-text {
            display: inline-block;
            line-height: 38px;
            margin: auto 0.75rem;
        }

        </style>
        <script type='text/javascript'>

            $(document).ready(function(){

                var panel_bg_color = 'var(--custom-panel-bg)';
    
                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db'],div[field='product_information_non_db'],div[field='office_use_tab_non_db']\").prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px');
                
                $(\"div[field='line_items']\").prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 15px 10px');

                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db'],div[field='product_information_non_db'],div[field='office_use_tab_non_db']\").addClass('hidden');
            });
        </script>";
	}

    /**
     * @param String ACLRole name
     * checks if current logged in user has a specific role
     * @return Boolean
     * Added by Glai Obido
     */
    private function checkLoggedUserRole($roleToCheck)
    {
        global $log, $current_user;
        
        $hasRole = false;

        $workgroupBeanArr = $this->bean->get_linked_beans(
            'cases_cwg_capaworkinggroup_1',
            'CWG_CAPAWorkingGroup',
            array(),
            0,
            -1,
            0,
            "cwg_capaworkinggroup.capa_roles = '".$roleToCheck."' 
            AND cwg_capaworkinggroup.parent_type = 'Users'
            AND cwg_capaworkinggroup.parent_id = '{$current_user->id}'");

            $hasRole = (count($workgroupBeanArr) > 0) ? true : false;

            return $hasRole;
    }
}
