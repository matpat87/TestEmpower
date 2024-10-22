<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Cases&action=UpdateCaseTypeValue
updateCustomerIssueType();
function updateCustomerIssueType() {
	global $db;

	$db = DBManagerFactory::getInstance();

	$sql = "UPDATE cases
					LEFT JOIN cases_cstm
						ON cases.id = cases_cstm.id_c
					SET cases_cstm.ci_type_c = 'QualityIssue'
                    WHERE cases_cstm.quality_issue_c = 1 ";

	echo '<pre>';
		print_r($sql);
	echo '</pre>';

	$db->query($sql);
}