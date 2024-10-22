<?php
require_once 'custom/QuickCRM/cache.php';
function qcrm_get_user_roles($user_id){
		global $sugar_config;
		$db = DBManagerFactory::getInstance();
		
	    $query = "SELECT acl_roles.name,acl_roles.id ".
                "FROM acl_roles ".
                "INNER JOIN acl_roles_users ON acl_roles_users.user_id = '$user_id' ".
                    "AND acl_roles_users.role_id = acl_roles.id AND acl_roles_users.deleted = 0 ".
                "WHERE acl_roles.deleted=0 ";

		if (isset($sugar_config['securitysuite_version'])){
	    	$query .= "UNION " .
				"SELECT acl_roles.name,acl_roles.id " .
				"FROM acl_roles " .
				"INNER JOIN securitygroups_users ON securitygroups_users.user_id = '$user_id' AND  securitygroups_users.deleted = 0 ".
				"INNER JOIN securitygroups_acl_roles ON securitygroups_acl_roles.role_id=acl_roles.id AND securitygroups_users.securitygroup_id = securitygroups_acl_roles.securitygroup_id and securitygroups_acl_roles.deleted = 0 ".
				"WHERE acl_roles.deleted=0";
		}
		
		$result = $db->query($query);

		$roles_names = array();
		$roles_ids = array();
        while($row = $db->fetchByAssoc($result))
        {
            $roles_ids[] = $row['id'];
            $roles_names[] = $row['name'];
        }
        
        return array(
        	'ids' => $roles_ids,
        	'names' => $roles_names,
        );
} 

function qcrm_user_data($user){
    global $sugar_config;
    global $current_language;
    
    $user_id = $user->id;
    $user->loadPreferences();

    $name_value_list = array();

	require_once('modules/QuickCRM/license/OutfittersLicense.php');
	$authorized = QOutfittersLicense::isValid('QuickCRM',$user_id) === true;



			if ($authorized){
				$name_value_list['fulluser'] = true;

				$role_defs = qcrm_get_user_roles($user_id);
				$name_value_list['roles'] = $role_defs['names']; 
				$name_value_list['role_ids'] = $role_defs['ids']; 

				if (isset($sugar_config['securitysuite_version'])){
					require_once('modules/SecurityGroups/SecurityGroup.php');
					$group= new SecurityGroup();
					$name_value_list['teams'] = $group->getUserSecurityGroups($user_id);				
				}
				else {
					$name_value_list['teams'] = false;								
				}
				
				$name_value_list['full_name'] = $user->full_name;		
				$name_value_list['emailAddress'] = $user->email1;		
				$name_value_list['signature'] = $user->getDefaultSignature();		

				$name_value_list['email_mode'] = $user->getPreference('email_link_type');
									
				$user->getPreference('reminder_checked');
				$reminder_time = "-1";
				if ($user->getPreference('reminder_checked')){
					$reminder_time = $user->getPreference('reminder_time');
				}
				$name_value_list['reminder_time'] = $reminder_time;

				$admin = new Administration();
            	$admin->retrieveSettings();
				$name_value_list['receive_notifications'] = $admin->settings['notify_on'] && $user->receive_notifications;
				
				global $locale;
				$cur_decimals = $locale->getPrecedentPreference('default_currency_significant_digits',$user);
				$name_value_list['currency_digits'] = array(
					'name' => 'currency_digits',
					'value' => $cur_decimals,
				);
			}
			else {
				$name_value_list['fulluser'] = false;				
				$name_value_list['roles'] = false;
				$name_value_list['teams'] = false;
			}
			$name_value_list['fdow'] = $user->get_first_day_of_week();

	return $name_value_list;

}

/**
 * Generate cryptographically secure short live token to re-create a new session
 * to authenticate REST API of a given [user_id].
 * @param string $user_id current user's id.
 * @return string generated token
 * @throws Exception if [user_id] is empty.
 *
 *
 * Many thanks to Yathit Mobile App Service for their contribution
 */

function get_seamless_token($user_id)
{
    if (empty($user_id)) {
        throw new Exception("user_id must not be empty");
    }
    $crypto_strong = true;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $crypto_strong));
    $ttl_second = 120;
    $c = new QCRMCache();
    $c->store($token, $user_id, $ttl_second);
    // sugar_cache_put does not persist across session
    return $token;
}

/**
 * Retrieve back [user_id] from the token.
 * @param string $token previously generated token.
 * @return string [user_id] associated with the token.
 */
function get_user_id_from_token($token)
{
    $c = new QCRMCache();
    $id = $c->retrieve($token);
    return $id;
}

