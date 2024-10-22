<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Users&action=ResetUsersDefaultEmailClient
resetUsersDefaultEmailClient();

function resetUsersDefaultEmailClient() {
	$userBean = BeanFactory::getBean('Users');
	$usersList = $userBean->get_full_list();

	foreach ($usersList as $user) {
		$user->setPreference('email_link_type', 'mailto');
	}
}