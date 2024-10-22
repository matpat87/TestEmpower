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


class QCRM_HomepageViewDetail extends ViewDetail
{
 	private $visible_modules;
 	public function __construct()
 	{
 		parent::__construct();
		require_once('modules/MySettings/TabController.php');
    	$controller = new TabController();    	
        $visible_modules = array('Employees');
        $tabs = $controller->get_tabs_system();
        foreach ($tabs[0] as $key=>$value){
            $visible_modules[] = $key;
        }
        $this->visible_modules = $visible_modules;
 	}

	public function display_module($module){
		global $app_list_strings;
		$module_label = $module;
		if (!empty($app_list_strings['moduleList'][$module])){
			$module_label = $app_list_strings['moduleList'][$module];
		}
		return '<li id="S_'.$module.'">'.$module_label.'</li>';
	}

	public function decode_hidden($hidden)
	{
		require_once('custom/modules/Administration/QuickCRM_utils.php');
		$qutils=new QUtils();
		$qutils->LoadMobileConfig(true); // refresh first open only
		$current_config = $qutils->mobile;
		$enabled= $current_config['modules'];
		
		$list = array();
		if (!empty($hidden)) $list = json_decode(base64_decode($hidden));
		$nohidden_list = "";
		foreach($enabled as $module){	
			if (in_array($module,$this->visible_modules) && (!isset($current_config['show_module'][$module]) || $current_config['show_module'][$module])){
				if (!in_array($module,$list)){
					$nohidden_list .= $this->display_module($module,'I');
				}
			}
		}
		return $nohidden_list;
	}

	public function decode_creates($creates)
	{
		$list = array();
		if (!empty($creates)) $list = json_decode(base64_decode($creates));
		$str = "";
		foreach ($list as $idx => $module){
			$str .= $this->display_module($module);
		}
		return $str;
	}

	public function display_chart($chart_id,$report_id){
		$chart = BeanFactory::getBean('AOR_Charts',$chart_id);
		if (!$chart) return '';
		$report = BeanFactory::getBean('AOR_Reports',$report_id);
		if (!$report) return '';
		$label = $report->name;
		if (!empty($chart->name)){
			$label .= ' / ' . $chart->name;
		}
		return '<li id="CHA'.$chart_id.'" >'.$label.'</li>';
	}

	public function decode_charts($charts)
	{
		$list = array();
		if (!empty($charts)) $list = json_decode(base64_decode($charts));
		$str = "";
		foreach ($list as $idx => $data){
			$str .= $this->display_chart($data->id,$data->report_id);
		}
		return $str;
	}

	public function decode_dashlets($dashlets)
	{
		$list = array();
		if (!empty($dashlets)) $list = json_decode(base64_decode($dashlets));
		$str = "";
		foreach ($list as $idx => $def){
			if($def->type == 'Search'){
				$search = BeanFactory::getBean('QCRM_SavedSearch',$def->id);
				if ($search){
					$cl = $search->is_public() ? 'PublicSearch' : 'PrivateSearch';
					$str .= '<li id="S_'.$def->id.'" class="' . $cl . '" >'.$search->name.'</li>';
				}
			}
			else if($def->type == 'bean'){
				$bean = BeanFactory::getBean($def->module,$def->id);
				if ($bean){
					$str .= '<li id="S_'.$def->id.'" >'.$search->name.'</li>';
				}
			}
		}
		return $str;
	}
	public function decode_icons($icons)
	{
		$list = array();
		if (!empty($icons)) $list = json_decode(base64_decode($icons));
		$str = "";
		foreach ($list as $idx => $def){
			if($def->type == 'Search'){
				$search = BeanFactory::getBean('QCRM_SavedSearch',$def->id);
				if ($search){
					$cl = $search->is_public() ? 'PublicSearch' : 'PrivateSearch';
					$str .= '<li id="S_'.$def->id.'" class="' . $cl . '">'.$search->name.'</li>';
				}
			}
			else if($def->type == 'bean'){
				$bean = BeanFactory::getBean($def->module,$def->id);
				if ($bean){
					$str .= '<li id="S_'.$def->id.'" >'.$search->name.'</li>';
				}
			}
		}
		return $str;
	}

	public function display_header($str){
		return "<div style='text-align:center'><strong><span style='font-size:larger;'>$str</span></strong></div>";
	}

	public function get_users_list(){
		$res = get_user_array(true, 'Active', '', true);
		return $res;
	}
	
	public function get_roles_list(){
		return get_bean_select_array(true, 'ACLRole','name','','name');
	}
	
 	public function display()
 	{
 		global $sugar_config, $current_user, $mod_strings,$current_language;
		global $app_list_strings, $app_strings;

		$this->ss->assign('IS_ADMIN', $current_user->is_admin);

		$homepage_id = $this->bean->id;
 		$icons_label = $this->display_header($mod_strings['LBL_ICONS']);
 		$dashlets_label = $this->display_header($mod_strings['LBL_DASHLETS']);
		$this->ss->assign('icons_label', $icons_label);
		$this->ss->assign('dashlets_label', $dashlets_label);

		if (isset($this->bean->id) && !empty ($this->bean->id)) {
			if (!empty ($this->bean->icons)){
				$this->ss->assign('icons_list', $this->decode_icons($this->bean->icons));
			}
			if (!empty ($this->bean->dashlets)){
				$this->ss->assign('dashlets_list', $this->decode_dashlets($this->bean->dashlets));
			}
			if (!empty ($this->bean->creates)){
				$this->ss->assign('creates_list', $this->decode_creates($this->bean->creates));
			}			
			if (!empty ($this->bean->charts)){
				$this->ss->assign('charts_list', $this->decode_charts($this->bean->charts));
			}			
			$this->ss->assign('nohidden_list', $this->decode_hidden($this->bean->hidden));
		}

		if (isset($app_list_strings['aok_status_list'])){
			$public_label = $app_list_strings['aok_status_list']['published_public'];
			$private_label = $app_list_strings['aok_status_list']['published_private'];
		}
		else if ($sugar_config['sugar_version']<'6.3'){
			$public_label = 'Public';
			$private_label = 'Private';
		}
		else
		{
			$public_label = $app_strings['LBL_SHARE_PUBLIC'];
			$private_label = $app_strings['LBL_SHARE_PRIVATE'];
		}
		$this->ss->assign('public_label', $public_label);
		$this->ss->assign('private_label', $private_label);

		//$this->ss->assign('users_list', $this->get_users_list());
		//$this->ss->assign('roles_list', $this->get_roles_list());

		parent::display();
		echo <<<EOQ
			<style>
			.connectedSortable { min-height:20px; border-color: black;border-style: solid; border-width:1px; text-align:center ;margin:10px; width: 280px;float: left; margin-right: 10px; }
			.PublicSearch { padding-left:10px; background: #9FF99F;}
			.PrivateSearch { padding-left:10px; background: #EAABA4;}
			.legend { float: left; padding:5px 10px;}
			</style>
			<script>
				$('#shared').parent().hide();
			</script>
EOQ;

        echo '	<div id="popupDiv_ara" style="
    display: none;
    position: fixed;
    top: 35%;
    left: 40%;
    opacity: 1;
    width: 35%;
    padding: 20px;
    z-index: 9999;
    background: rgb(246, 246, 246);
    border: 2px solid;">
    <button class="button" onclick="copyToAll()">' . $mod_strings['LBL_COPY_ALL_USERS'] . '</button>
	<br>
    <button class="button" onclick="copyToRole()">' . $mod_strings['LBL_COPY_ROLE'] . '</button>
    <select name="copy_role" id="copy_role">';
        foreach ($this->get_roles_list() as $k => $v) {
            echo '<option value="' . $k . '">' . $v . '</option>';
        }
    echo '</select>
			<br>            
			<br>            
            <button class="button" onclick="closePopup()">'.$app_strings['LBL_CANCEL_BUTTON_TITLE'].'</button>
	
				</div>
				<script>
				function closePopup() {
				  $(\'#popupDiv_ara\').hide();
				}
				function copyToRole() {
			    	if($(\'#copy_role\').val() != "" ){
					    if(confirm("'. $mod_strings['LBL_COPY_WARNING'] .'")){
				      		$.ajax({
                            	type: "POST",
	                            data:\'to_pdf=true&role_id=\'+$(\'#copy_role\').val()+\'&record=\'+\''.$homepage_id.'\',
    	                        dataType:"json",
        	                    url: "index.php?module=QCRM_Homepage&action=copyrole",
            	                success: function(data) {
                	                if(data==\'ok\'){
                    	            	$(\'#popupDiv_ara\').hide();
										window.location.href = "index.php?action=index&module=QCRM_Homepage";
                            	    }
                            	}
                    		});
						}
					}
                }
				function copyToAll() {
				    if(confirm("'. $mod_strings['LBL_COPY_WARNING'] .'")){
				      	$.ajax({
                            type: "POST",
                            data:\'to_pdf=true&record=\'+\''.$homepage_id.'\',
                            dataType:"json",
                            url: "index.php?module=QCRM_Homepage&action=copytoall",
                            success: function(data) {
                                if(data==\'ok\'){
                                	$(\'#popupDiv_ara\').hide();
									window.location.href = "index.php?action=index&module=QCRM_Homepage";
                                }
                            }
                    	});
					}
                }
	
				</script>';

 	}
}