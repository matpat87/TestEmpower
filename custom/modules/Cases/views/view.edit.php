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

    function display(){
        parent::display();

        // Hide input fields so that custom non-db fields will display labels only
        // Added by: Ralph Julian Siasat
        echo 
        "<script>
            $(document).ready(function(){
                var panel_bg_color = $('li.active > a').first().css('background-color');
        
                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db']\").prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 8px 10px').parent().css('padding-left', '0px');

                $(\"div[field='product_header_non_db']\").prev().css('margin-top', '0px');

                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db']\").addClass('hidden');
            });
        </script>";
        
        global $sugar_config;
        $new = empty($this->bean->id);
        if($new){
            ?>
            <script>
                $(document).ready(function(){
                    $('#update_text').closest('.edit-view-row-item').hide();
                    $('#update_text_label').closest('.edit-view-row-item').hide();
                    $('#internal').closest('.edit-view-row-item').hide();
                    $('#internal_label').closest('.edit-view-row-item').hide();
                    $('#addFileButton').closest('.edit-view-row-item').hide();
                    $('#case_update_form_label').closest('.edit-view-row-item').hide();
                    tinyMCE.execCommand('mceAddControl', false, document.getElementById('description'));

                    $("select[name='site_c']").on('change',function(event) {
                        event.preventDefault();
                        var selectedSite = $(this).val();

                        $.ajax({
                            url: "index.php?entryPoint=retrieveCaseSiteLabManagers&to_pdf=1",
                            data: {
                                selectedSite: selectedSite
                            },
                            success: function(result){
                                var jsonResult = JSON.parse(result);

                                if(jsonResult) {
                                    $("#users_cases_1_name").val(jsonResult.first_name + ' ' + jsonResult.last_name);
                                    $("#users_cases_1users_ida").val(jsonResult.id);
                                } else {
                                    $("#users_cases_1_name").val('');
                                    $("#users_cases_1users_ida").val('');
                                }
                            }
                        });
                    })
                    
                });
            </script>
        <?php
        }
    }
}
