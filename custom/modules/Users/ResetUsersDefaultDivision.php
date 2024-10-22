<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Users&action=ResetUsersDefaultDivision
resetUsersDefaultDivision();

function resetUsersDefaultDivision() {
	$userBean = BeanFactory::getBean('Users');
	$usersList = $userBean->get_full_list();

	foreach ($usersList as $user) {
		echo "{$user->name} Current Division: {$user->division_c} <br>";
		$user->division_c = 'ChromaColor';
		$user->save();
		echo "{$user->name} New Division: {$user->division_c} <br>";
	}
}