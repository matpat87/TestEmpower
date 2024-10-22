<?php

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	require_once('custom/entrypoints/classes/CustomerIssueQualityAlertPDF.php');

	$customerIssueDispositionForm = new CustomerIssueQualityAlertPDF($_POST['customer_issue_id']);
	$customerIssueDispositionForm->generatePDF();

?>