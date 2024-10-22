<?php

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	require_once('custom/entrypoints/classes/CustomerIssueDispositionFormPDF.php');

	$customerIssueDispositionForm = new CustomerIssueDispositionFormPDF($_POST['customer_issue_id']);
	$customerIssueDispositionForm->generatePDF();

?>