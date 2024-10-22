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

class SecurityGroupsViewDetail extends ViewDetail {


 	function __construct(){
 		parent::__construct();
 	}

 	/**
 	 * display
 	 * Override the display method to support customization for the buttons that display
 	 * a popup and allow you to copy the account's address into the selected contacts.
 	 * The custom_code_billing and custom_code_shipping Smarty variables are found in
 	 * include/SugarFields/Fields/Address/DetailView.tpl (default).  If it's a English U.S.
 	 * locale then it'll use file include/SugarFields/Fields/Address/en_us.DetailView.tpl.
 	 */
 	function display(){
		global $app_list_strings;

		if(empty($this->bean->id)){
			global $app_strings;
			sugar_die($app_strings['ERROR_NO_RECORD']);
		}

		$this->dv->process();
		echo $this->dv->display();
		$this->AddJS();
        $this->hideDeleteButton();
	 }

     private function hideDeleteButton()
     {
         if (in_array($this->bean->type_c, ['CAPAWorkingGroup', 'TRWorkingGroup', 'RRWorkingGroup'])) {
             echo "<style>#delete_button {display: none !important;}</style>";
         }
     }

     private function AddJS()
     {
         $record_id = $this->bean->id;
 
         echo <<<EOL
             <script type="text/javascript">
                 $(document).ready(function(e){
                     var distro_open_popup = 'open_popup("DSBTN_Distribution",600,400,"",true,true,{"call_back_function":"set_return_and_save_background","form_name":"DetailView","field_to_name_array":{"id":"subpanel_id", "from": "from", "securitygroups": "SecurityGroups"},"passthru_data":{"child_field":"securitygroups_dsbtn_distribution","return_url":"index.php%3Fmodule%3DSecurityGroups%26action%3DSubPanelViewer%26subpanel%3Dsecuritygroups_dsbtn_distribution%26record%3D{$record_id}%26sugar_body_only%3D1","link_field_name":"securitygroups_dsbtn_distribution","module_name":"securitygroups_dsbtn_distribution","refresh_page":0}},"MultiSelect",true);';
 
                     setInterval(function(e){
                         var distro_open_popup_new = $('input[name="securitygroups_dsbtn_distribution_select_button"]').attr('onclick');
 
                         if(distro_open_popup_new != distro_open_popup){
                             $('input[name="securitygroups_dsbtn_distribution_select_button"]').attr('onclick', distro_open_popup);
                             distro_open_popup_new = distro_open_popup;
                         }
                     }, 500);
                 })
                 
             </script>
EOL;
     }
}

