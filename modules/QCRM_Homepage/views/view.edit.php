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


class QCRM_HomepageViewEdit extends ViewEdit
{
 	private $visible_modules;
 	private $public_label;
 	private $private_label;
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
        
		if (isset($app_list_strings['aok_status_list'])){
			$this->public_label = $app_list_strings['aok_status_list']['published_public'];
			$this->private_label = $app_list_strings['aok_status_list']['published_private'];
		}
		else if ($sugar_config['sugar_version']<'6.3'){
			$this->public_label = 'Public';
			$this->private_label = 'Private';
		}
		else
		{
			$this->public_label = $app_strings['LBL_SHARE_PUBLIC'];
			$this->private_label = $app_strings['LBL_SHARE_PRIVATE'];
		}
 	}

	public function display_module($module,$prefix='S'){
		global $app_list_strings;
		$module_label = $module;
		if (!empty($app_list_strings['moduleList'][$module])){
			$module_label = $app_list_strings['moduleList'][$module];
		}
		return '<li id="'.$prefix.'_'.$module.'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$module_label.'</li>';
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
		return '<li id="CHA'.$chart_id.'" data-qchart="'.$chart->id.'" data-qreport="'.$report->id.'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$label.'</li>';
	}

	public function decode_charts($charts)
	{
		$list = array();
		if (!empty($charts)) $list = json_decode(base64_decode($charts));
		$str = "";
		$charts_ids = array();
		foreach ($list as $idx => $data){
			$charts_ids[] = $data->id;
			$str .= $this->display_chart($data->id,$data->report_id);
		}
		return array('charts' => $charts_ids, 'list' => $str);
	}
	
	public function decode_creates($creates)
	{
		$list = array();
		if (!empty($creates)) $list = json_decode(base64_decode($creates));
		$str = "";
		$creates_ids = array();
		foreach ($list as $idx => $module){
			$creates_ids[] = $module;
			$str .= $this->display_module($module);
		}
		return array('modules' => $creates_ids, 'list' => $str);
	}

	public function decode_hidden($hidden)
	{
		$list = array();
		if (!empty($hidden)) $list = json_decode(base64_decode($hidden));
		$str = "";
		$hidden_ids = array();
		foreach ($list as $idx => $module){
			$hidden_ids[] = $module;
			$str .= $this->display_module($module,'I');
		}
		return array('modules' => $hidden_ids, 'list' => $str);
	}

	public function display_search($search){
		global $app_list_strings;
		global $current_user;
		
		if (!$search){
			return '';
		}
		$module = $search->type;
		$module_label = $module;
		if (!empty($app_list_strings['moduleList'][$module])){
			$module_label = $app_list_strings['moduleList'][$module];
		}
		$cl = 'Search';
		$cl .= $search->shared ? ' PublicSearch' : ' PrivateSearch';
		if ($search->assigned_user_id == $current_user->id) {
			$cl .= ' SearchMyItems';
		}
		if ($search->assigned_user_id == $current_user->id || is_admin($current_user)) {
			$toggle_buttons = '&nbsp;<button class="MakePublic" type="button" onclick="toggleSearch(this)">->'.$this->public_label.'</button><button class="MakePrivate" type="button" onclick="toggleSearch(this)">->'.$this->private_label.'</button>';
		}
		else{
			$toggle_buttons = '';
		}
		
		return '<li data-qtype="Search" data-qmodule="'.$search->type.'" data-userid="'.$search->assigned_user_id.'" id="S_'.$search->id.'" class="' . $cl . '"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$search->name.'<br>('.$module_label.')'.$toggle_buttons.'</li>';
	}

	public function display_bean($bean,$module){
		global $app_list_strings;
		
		if (!$bean){
			return '';
		}
		$module_label = $module;
		if (!empty($app_list_strings['moduleList'][$module])){
			$module_label = $app_list_strings['moduleList'][$module];
		}
		$cl = 'Bean';
		
		return '<li data-qtype="Bean" data-qmodule="'.$module.'" data-userid="'.$bean->assigned_user_id.'" id="S_'.$bean->id.'" class="' . $cl . '"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$bean->name.'<br>('.$module_label.')</li>';
	}

	public function decode_dashlets($dashlets)
	{
		$list = array();
		if (!empty($dashlets)) $list = json_decode(base64_decode($dashlets));
		$str = "";
		$search_ids = array();
		$all_public =true;
		foreach ($list as $idx => $def){
			if($def->id == 'Today'){
				$str .= '<li data-qtype="Preset" id="S_'.$def->id.'" style="display:none;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Today</li>';
			}
			else{
				$search_ids[] = $def->id;
				$search = BeanFactory::getBean('QCRM_SavedSearch',$def->id);
				if ($def->type == 'Search'){
					$search = BeanFactory::getBean('QCRM_SavedSearch',$def->id);
					$str .= $this->display_search($search);
				}
				else if ($def->type == 'bean'){
					$bean = BeanFactory::getBean($def->module,$def->id);
					$str .= $this->display_bean($bean,$def->module);
				}
			}
		}
		return array('all_public' => $all_public,'ids' => $search_ids, 'list' => $str);
	}
	public function decode_icons($icons)
	{
		$list = array();
		if (!empty($icons)) $list = json_decode(base64_decode($icons));
		$str = "";
		$search_ids = array();
		$all_public =true;
		foreach ($list as $idx => $def){
			$search_ids[] = $def->id;
			if ($def->type == 'Search'){
				$search = BeanFactory::getBean('QCRM_SavedSearch',$def->id);
				$str .= $this->display_search($search);
			}
			else if ($def->type == 'bean'){
				$bean = BeanFactory::getBean($def->module,$def->id);
				$str .= $this->display_bean($bean,$def->module);
			}
		}
		return array('all_public' => $all_public,'ids' => $search_ids, 'list' => $str);
	}
	
	public function display_header($str){
		return "<div style='text-align:center'><strong><span style='font-size:larger;'>$str</span></strong></div>";
	}
	
 	public function display()
 	{
 		global $sugar_config, $current_user, $mod_strings,$current_language;
		global $app_list_strings, $app_strings;
 		
		require_once('custom/modules/Administration/QuickCRM_utils.php');
		$qutils=new QUtils();
		$qutils->LoadMobileConfig(true); // refresh first open only
		$current_config = $qutils->mobile;
		$enabled= $current_config['modules'];
		
 		$user = $current_user;
 		$icons_label = $this->display_header($mod_strings['LBL_ICONS']);
 		$dashlets_label = $this->display_header($mod_strings['LBL_DASHLETS']);
		$MBmod_strings=return_module_language($current_language, 'ModuleBuilder');
		$unused_label = $this->display_header($MBmod_strings['LBL_HIDDEN']);
 		
 		$used_searches = array();
 		$used_modules = array();
 		$icons_list = '';
 		$dashlets_list = '';
 		$unused_list = '';
 		$creates_list = '';
 		$nocreates_list = '';
 		$hidden_list = '';
 		$nohidden_list = '';
 		$all_searches_public = true;
 		
		if (!empty ($this->bean->icons)){
				$icons = $this->decode_icons($this->bean->icons);
				$used_searches = array_merge($used_searches,$icons['ids']);
				$icons_list .= $icons['list'];
				if (!$icons['all_public']) $all_searches_public = false;
		}
		if (!empty ($this->bean->dashlets)){
				$dashlets = $this->decode_dashlets($this->bean->dashlets);
				$used_searches = array_merge($used_searches,$dashlets['ids']);
				$dashlets_list .= $dashlets['list'];
				if (!$dashlets['all_public']) $all_searches_public = false;
		}
		if (!empty ($this->bean->creates)){
				$modules= $this->decode_creates($this->bean->creates);
				$used_modules = $modules['modules'];
				$this->ss->assign('creates_list', $modules['list']);
		}			
		if (!empty ($this->bean->charts)){
				$charts= $this->decode_charts($this->bean->charts);
				$this->ss->assign('charts_list', $charts['list']);
		}			

		$modules= $this->decode_hidden($this->bean->hidden);
		$used_icons = $modules['modules'];
		$this->ss->assign('hidden_list', $modules['list']);

		$user = BeanFactory::getBean('Users',$this->bean->assigned_user_id);

		foreach($enabled as $module){	
			if (in_array($module,$this->visible_modules) && (!isset($current_config['show_module'][$module]) || $current_config['show_module'][$module])){
				if (!in_array($module,$used_modules)){
					// button is not displayed
					if (!isset($current_config['create_subpanel'][$module]) || !$current_config['create_subpanel'][$module]){
						// module is not "create from subpanel only"
						$nocreates_list .= $this->display_module($module);
					}
				}
				if (!in_array($module,$used_icons)){
					$nohidden_list .= $this->display_module($module,'I');
				}
			}
		}
		$this->ss->assign('nocreates_list', $nocreates_list);
		$this->ss->assign('nohidden_list', $nohidden_list);
				
		$this->ss->assign('icons_list', $icons_list);
		$this->ss->assign('dashlets_list', $dashlets_list);

		// get searches allowed to user
		$searchObj = BeanFactory::getBean('QCRM_SavedSearch');
		$AllSearches = $searchObj->visible_searches($user);
		
		//
		$unused_searches = array();
		foreach ($AllSearches as $search){
			if (!in_array($search->id,$used_searches)){
				$unused_searches[]=$search;
			}
		}

		foreach ($unused_searches as $search){
			$unused_list .= $this->display_search($search);
		}
		$this->ss->assign('unused_list', $unused_list);

		$this->ss->assign('icons_label', $icons_label);
		$this->ss->assign('dashlets_label', $dashlets_label);
		$this->ss->assign('unused_label', $unused_label);

		$this->ss->assign('public_label', $this->public_label);
		$this->ss->assign('private_label', $this->private_label);
		
		// adds support for old sugar versions
		if ($sugar_config['sugar_version']<'6.5.16'){
			echo <<<EOQ
				<script type="text/javascript" src="custom/QuickCRM/lib/js/jquery-1.7.2.min.js"></script>
EOQ;
		}

		// adds support for old suitecrm versions
		$suitecrm = false;
		if (isset($sugar_config['suitecrm_version']) ){
			$suitecrm = $sugar_config['suitecrm_version'];
		}
		else if (file_exists('suitecrm_version.php')){
			include('suitecrm_version.php');
			$suitecrm = $suitecrm_version;
		}
		
		if (!$suitecrm || !version_compare($suitecrm, '7.2', '>=')) {
			echo <<<EOQ
			<script type="text/javascript" src="custom/QuickCRM/lib/js/jquery-ui-1.8.21.custom.min.js"></script>
EOQ;
		}

		parent::display();
		echo <<<EOQ
			<style>
			.Sortable, .ISortable, .CSortable, .connectedSortable { min-height:30px; border-color: black;border-style: solid; border-width:1px; text-align:center ;margin:10px; width: 280px;list-style-type: none; float: left; margin-right: 10px; }
			ul.Sortable, ul.ISortable, ul.CSortable, ul.connectedSortable { padding-inline-start: 0px;}
			
			.Sortable li, .ISortable li, .CSortable li, .connectedSortable li { margin: 5px 0px;font-size: 1.2em; }
			.Sortable li span, .ISortable li span, .CSortable li span, .connectedSortable li span { position: absolute;}
			.PublicSearch { background: #9FF99F;}
			.PrivateSearch { background: #EAABA4;}
			.legend { float: left; padding:5px 10px;}
			#unused_ul li span, #hidden_ul li span, #nocreates_ul li span, #nocharts_ul li span { display: none;}
			.PublicSearch .MakePublic, .PrivateSearch .MakePrivate {display:none;}
			</style>
			<script>
				$("div[data-label='LBL_DASHLETS']").hide();
				$("div[field='dashlets']").css('width','100%');
				
				$( ".connectedSortable" ).sortable({
					connectWith: ".connectedSortable"
				}).disableSelection();
				$( ".Sortable" ).sortable({
					connectWith: ".Sortable"
				}).disableSelection();
				$( ".ISortable" ).sortable({
					connectWith: ".ISortable"
				}).disableSelection();
				$( ".CSortable" ).sortable({
					connectWith: ".CSortable"
				}).disableSelection();
				
				function toggleSearch(element){
					var l = $(element).closest('li');
					if (l.hasClass('PublicSearch')){
						l.addClass('PrivateSearch');
						l.removeClass('PublicSearch');
					}
					else {
						l.addClass('PublicSearch');
						l.removeClass('PrivateSearch');
					}
					return false;
				}
				
				function storeSearches(list,id){
					var arr = $('#'+list).sortable( 'toArray'),
						new_arr = [];
					for (var key in arr){
						var idfield=arr[key],
							field = idfield.replace('S_',''),
							elt = $('#'+idfield),
							type, module,
							res = {id:field};
						if (elt.data('qtype')){
							res['type'] = elt.data('qtype');
							if (elt.data('qmodule') && elt.data('qmodule') != ''){
								res['module'] = elt.data('qmodule');
							}
							if (elt.hasClass('PrivateSearch')){
								res['shared']=0;
							}
							else{
								res['shared']=1;
							}
							new_arr.push(res);
						}
					}
					$('#'+id).val(btoa(JSON.stringify(new_arr)));					
				}
				function storeCharts(list,id){
					var arr = $('#'+list).sortable( 'toArray'),
						new_arr = [];
					for (var key in arr){
						var idfield=arr[key],
							elt = $('#'+idfield),
							res = {module:'AOR_Reports'};
						if (elt.data('qchart') && elt.data('qreport')){
							res['id'] = elt.data('qchart');
							res['report_id'] = elt.data('qreport');
							new_arr.push(res);
						}
					}
					$('#'+id).val(btoa(JSON.stringify(new_arr)));					
				}
				function storeCreates(list,id){
					var arr = $('#'+list).sortable( 'toArray'),
						new_arr = [];
					for (var key in arr){
						var field = arr[key].replace('S_','');
						new_arr.push(field);
					}
					$('#'+id).val(btoa(JSON.stringify(new_arr)));					
				}
				function storeHidden(list,id){
					var arr = $('#'+list).sortable( 'toArray'),
						new_arr = [];
					for (var key in arr){
						var field = arr[key].replace('I_','');
						new_arr.push(field);
					}
					$('#'+id).val(btoa(JSON.stringify(new_arr)));					
				}
			</script>
EOQ;

 	}
}