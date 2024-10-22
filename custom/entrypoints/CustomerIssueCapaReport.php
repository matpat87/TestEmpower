<?php
	require_once('custom/entrypoints/classes/CustomerIssueCapaReportPDF.php');

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
    
	$customerIssueCapa = new CustomerIssueCapaReportPDF($_POST['customer_issue_id']);
	$customerIssueCapa->generatePDF();
	// $trPrintout->process();
	// $trPrintout->printPDF();
?>