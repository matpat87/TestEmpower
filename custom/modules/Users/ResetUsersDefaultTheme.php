<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Users&action=ResetUsersDefaultTheme
resetUsersDefaultTheme();

function resetUsersDefaultTheme() {
	global $db;

	$db = DBManagerFactory::getInstance();

	$sql = "SELECT user_preferences.id, user_preferences.contents 
				FROM user_preferences 
			WHERE user_preferences.category = 'global' 
				AND user_preferences.deleted = 0";
	$result = $db->query($sql);

	while($row = $db->fetchByAssoc($result) )
	{
		$contents = unserialize(base64_decode($row['contents']));
	    $contents['subtheme'] = 'Day';
	    $updatedContents = base64_encode(serialize($contents));

	    $updateSQL = "UPDATE user_preferences SET contents = '".$updatedContents."' WHERE id = '" . $row['id'] . "'";
	    $db->query($updateSQL);

	    echo '<pre>';
	    	print_r($updateSQL);
	    echo '</pre><br>';
	}
}