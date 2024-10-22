<?PHP
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/QCRM_Homepage/QCRM_Homepage_sugar.php');
class QCRM_Homepage extends QCRM_Homepage_sugar {
	
	public $copy_in_progress;
	public function __construct(){
		parent::__construct();
		$this->copy_in_progress = false;
	}

	public function setDefaultHomepage($clear){
		global $sugar_config;
		
		require_once('custom/modules/Administration/QuickCRM_utils.php');
		$configurator = new Configurator();
		$configurator->loadConfig();
		$new_default = $clear?'':$this->id;
		if (!isset($configurator->config['quickcrm_default_homepage']) || $configurator->config['quickcrm_default_homepage'] != $new_default){
			$configurator->config['quickcrm_default_homepage'] = $new_default;
			$configurator->handleOverride();
			// update QuickCRM config
			$sugar_config['quickcrm_default_homepage'] = $clear?'':$this->id;
			if (!$clear){
				// rebuild config so that new default homepage is pulled by app
				$qutils=new QUtils();
				$qutils->LoadConfig(true);
				$qutils->SaveConfig();
			}
		}
	}

	function checkPublicSearches(){
		$dashlets = json_decode(base64_decode($this->dashlets));
		$icons = json_decode(base64_decode($this->icons));
		$searches = array_merge($dashlets, $icons); 
		$all_public = true;
		foreach ($searches as $idx => $def){
			$search = BeanFactory::getBean('QCRM_SavedSearch',$def->id);
			if (!$search->is_public()){
				$all_public = false;
				break;
			}
		}
		return $all_public;
	}
	
	public function copyToUsers($role="", $selected_user_id=""){
		global $db, $current_user, $sugar_config;

			$status = true;

			require_once('custom/modules/Administration/QuickCRM_utils.php');
			if (!empty($this->id)){
				$homepage_id=$this->id;
				if ($selected_user_id==""){
					$mobile_users = QUtils::getMobileUsers();
				}
				else {
					$mobile_users = array($selected_user_id);
				}
				if ($selected_user_id=="" && $role == ''){
					// set this home page as default for all users
					$this->setDefaultHomepage(false);
				}
				else {
					// clear default homepage
					$this->setDefaultHomepage(true);
				}
				foreach ($mobile_users as $user_id){
					if ($user_id == $this->assigned_user_id){
					    // delete other homepage definitions
						$qry = "DELETE FROM qcrm_homepage WHERE assigned_user_id='" . $user_id . "' AND id != '". $homepage_id . "'";
						$db->query($qry);
					}
					else{
						$copy_it = true;
						if ($role != ''){
							$copy_it = in_array($role, QUtils::get_user_roles($user_id,true));
						}
						if ($copy_it){
					    	// delete existing homepage definitions
					    	$qry = "DELETE FROM qcrm_homepage WHERE assigned_user_id='" . $user_id . "' AND id != '". $homepage_id . "'";
							$db->query($qry);
							
							$seed = @clone($this);
							$seed->id = '';
							$seed->assigned_user_id=$user_id;
							$seed->copy_in_progress = true;
							$seed->save(false);
						}
					}
				}
			}
	}

	public function save($check_notify = FALSE) {
		global $log;
		if (!isset($_POST['rest_data']) && !$this->copy_in_progress){
			if (!empty($this->dashlets)){
				$dashlets = json_decode(base64_decode($this->dashlets));
				$new_dashlets = array();
				foreach ($dashlets as $dashlet){
					$new_dashlets[]= array(
						'id'=>$dashlet->id,
						'module'=>$dashlet->module,
						'type'=>$dashlet->type,
					);
					if (isset($dashlet->shared)){
						$search = BeanFactory::getBean('QCRM_SavedSearch',$dashlet->id);
						if ($search && $search->ACLAccess('EditView')){
							$shared = $dashlet->shared == 1 ?1 : 0;
							if ($search->is_public() != $shared){
								$search->set_public($shared);
								$search->save(false);				
							}
						}
					}
				}
				$this->dashlets = base64_encode(json_encode($new_dashlets));
			}
			if (!empty($this->icons)){
				$icons = json_decode(base64_decode($this->icons));
				$new_icons = array();
				foreach ($icons as $idx => $icon){
					$new_icons[]= array(
						'id'=>$icon->id,
						'module'=>$icon->module,
						'type'=>$icon->type,
					);
					if (isset($icon->shared)){
						$search = BeanFactory::getBean('QCRM_SavedSearch',$icon->id);
						if ($search && $search->ACLAccess('EditView')){
							$shared = $icon->shared == 1 ?1 : 0;
							if ($search->is_public() != $shared){
								$search->set_public($shared);
								$search->save(false);				
							}
						}
					}
				}
				$this->icons = base64_encode(json_encode($new_icons));
			}
		}
		parent::save($check_notify) ; 

	
	}

    public function get_summary_text()
    {
		return $this->name . ' - ' . $this->assigned_user_name;
    }
	
}
?>