<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Opportunities&action=ResetOpportunityAssignments
resetOpportunityAssignments();

function resetOpportunityAssignments() {
	global $db;

	$db = DBManagerFactory::getInstance();

	$sql = "UPDATE opportunities SET assigned_user_id = created_by";

	echo '<pre>';
		print_r($sql);
	echo '</pre>';

	$db->query($sql);
}