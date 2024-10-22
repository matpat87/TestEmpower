<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Users&action=ResetUsersEmailAddress
resetUsersEmailAddress();

function resetUsersEmailAddress() {
	$userBean = BeanFactory::getBean('Users');
	$usersList = $userBean->get_full_list();

	foreach ($usersList as $user) {
		if ($user->division_c !== 'Epolin') {
			$lowercasedUsername = strtolower($user->user_name);
			$sugarEmailAddress = new SugarEmailAddress();
			$sugarEmailAddress->addAddress("{$lowercasedUsername}@chromacolors.com", true);
			$sugarEmailAddress->save($user->id, "Users");
		}
	}
}