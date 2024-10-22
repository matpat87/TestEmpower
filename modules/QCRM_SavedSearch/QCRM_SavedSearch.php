<?PHP
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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/QCRM_SavedSearch/QCRM_SavedSearch_sugar.php');
class QCRM_SavedSearch extends QCRM_SavedSearch_sugar {
	
	public function __construct(){
		parent::__construct();
	}

    public function visible_searches($user){
		global $sugar_config;
	    if ($sugar_config['dbconfig']['db_type'] =='mssql'){
			$shared_field = 'shared_rec';
	    }
	    else {
			$shared_field = 'shared';
	    }

    	$qry = "(". $shared_field . " = 1 OR assigned_user_id ='". $user->id ."')";
    	$response = $this->get_list("name", $qry);
		return $response['list'];
    }

    public function is_public(){
		global $sugar_config;
	    if ($sugar_config['dbconfig']['db_type'] =='mssql'){
			$shared_field = 'shared_rec';
	    }
	    else {
			$shared_field = 'shared';
	    }
    	return $this->$shared_field;
    }

    public function set_public($new_val){
		global $sugar_config;
	    if ($sugar_config['dbconfig']['db_type'] =='mssql'){
			$shared_field = 'shared_rec';
	    }
	    else {
			$shared_field = 'shared';
	    }
    	$this->$shared_field = $new_val;
    }

    public function get_summary_text()
    {
		global $app_list_strings, $app_strings, $sugar_config;
		
		if (isset($app_list_strings['aok_status_list'])){
			$public_label = $app_list_strings['aok_status_list']['published_public'];
		}
		else if ($sugar_config['sugar_version']<'6.3'){
			$public_label = 'Public';
		}
		else
		{
			$public_label = $app_strings['LBL_SHARE_PUBLIC'];
		}
		return $this->name . ' - ' . ($this->shared ? $public_label : $this->assigned_user_name);
    }
}
?>