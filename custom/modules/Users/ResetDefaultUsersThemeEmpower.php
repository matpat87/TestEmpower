<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Users&action=ResetDefaultUsersThemeEmpower
resetDefaultUsersThemeEmpower();

function resetDefaultUsersThemeEmpower() {
	$userBean = BeanFactory::getBean('Users');
	$userBeanList = $userBean->get_full_list();

	foreach ($userBeanList as $user) {
		$userPreference = new UserPreference($user);
		$userPreference->setPreference('user_theme', 'SuiteP');
		$userPreference->setPreference('subtheme', 'Empower');
		$userPreference->savePreferencesToDB();

		echo '<pre>';
			print_r("Name: {$user->name} <br>");
			print_r("Theme: {$userPreference->getPreference('user_theme')}  <br>");
			print_r("Sub Theme: {$userPreference->getPreference('subtheme')}  <br>");
		echo '</pre>';
	}
}