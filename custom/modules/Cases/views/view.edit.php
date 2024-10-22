<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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
require_once('include/MVC/View/views/view.edit.php');
require_once('include/SugarTinyMCE.php');
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');

class CasesViewEdit extends ViewEdit {

    function __construct(){
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function CasesViewEdit(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    function preDisplay()
    {
        // Set to Sales Rep field to blank on create
        // if(!$this->bean->fetched_row['id']) {
        //     $this->bean->assigned_user_id = '';
        //     $this->bean->assigned_user_name = '';

        //     echo '<script>
        //         $(document).ready(function() {
        //             $("#assigned_user_name, #assigned_user_id").val("");
        //         });
        //     </script>';
        // }

        $this->submitDraft();

        parent::preDisplay();
    }

    function display(){
        global $log, $current_user;
        
        $_SESSION['case_account_id'] = $this->bean->fetched_row['id'] ? $this->bean->account_id : '';

        $submitAsDraft = (isset($_REQUEST['submit_draft']) && $_REQUEST['submit_draft'] == true) ? 'true' : 'false';
        
        $customerItemBean = BeanFactory::getBean('CI_CustomerItems', $this->bean->ci_customeritems_cases_1ci_customeritems_ida);
        $this->bean->status_update_c = "";
        $this->bean->ci_customeritems_cases_1_name = $customerItemBean->product_number_c;
        
        
        // if current user is site Internal Auditor, enable Verified Status dropdown
        $isInternalAuditor = CapaWorkingGroupHelper::checkLoggedUserWorkgroupRole($this->bean, 'InternalAuditor', 'Internal Auditor');
        if (!$isInternalAuditor && !$current_user->is_admin) {
            echo "
                <script>
                    $(document).ready(function() {
                        $('select#verified_status_c').attr('disabled', true).css('background-color','#e8e8e8');
                    });
                </script>
            ";
        }

        // Hide input fields so that custom non-db fields will display labels only
        // Added by: Ralph Julian Siasat
        echo 
        " <style>
            #status-text {
                display: inline-block;
                padding: 0.75rem;
            }
        </style>
        <script>
            $(document).ready(function(){
                
                var panel_bg_color = 'var(--custom-panel-bg)';
                
                jQuery(\"form#EditView\").append(\"<input type='hidden' name='submit_draft' id='submit_draft' value='{$submitAsDraft}' />\");
        
                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db'],div[field='office_use_tab_non_db'],div[field='product_information_non_db']\").prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 8px 10px').parent().css('padding-left', '0px');
                
                $(\"div[field='line_items']\").prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '5px 0px 15px 10px').parent().css('padding-left', '0px');

                $(\"div[field='product_header_non_db']\").prev().css('margin-top', '0px');

                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db'],div[field='office_use_tab_non_db'],div[field='product_information_non_db']\").addClass('hidden');

                {$this->assignedToField()}
            });
        </script>";

        $this->customLineItemCSS();

        parent::display();

        // Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script src='custom/modules/Cases/js/custom-edit.js?v={$guid}'></script>";
    }

    private function submitDraft()
    {
        global $log;

        if (isset($_POST['submit_draft']) && $_POST['submit_draft'] && $this->bean->status == 'Draft') {

            echo "
                <style>
                    #EditView_tabs .nav-tabs > li[role=presentation]:not(:first-child) {
                        display: none !important;
                    }
                </style>
            ";

            $this->bean->status = 'New';
        }
    }

    private function assignedToField()
    {
        global $current_user;
        $customJS = "";

        if (!$current_user->is_admin) {
            $customJS = "$('#assigned_user_name').addClass('custom-readonly');
                $('#btn_assigned_user_name, #btn_clr_assigned_user_name').css(\"display\", \"none\");
            ";
        }

        return $customJS;
    }

    private function customLineItemCSS()
    {
        echo
        "<style>
            div.edit-view-field[field='line_items'], table#lineItems { background: #F5F5F5 }
            .product_lot_name { width: 150px !important; }
            .product_lot_name_button { margin-right: 30px; }
            tbody[id^='product_body'] * td { padding-bottom: 23px !important;}
            .product_delete_line { margin: 0px !important; margin-right: 4px !important; margin-bottom: 4px !important;}
            #lineItems .group > thead:first-of-type { display: none !important; }
            #lineItems .group > thead:nth-child(2) { padding-top: 25px; padding-bottom: 10px !important; }
            #lineItems .group > thead:last-of-type { display: none !important; } 
            tbody[id^='product_body'] * td:nth-child(5), tbody[id^='product_body'] * td:nth-child(6) { width: 4% !important; }
         </style>";
    }
}
