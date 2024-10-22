<?php
	require_once('custom/entrypoints/classes/TRPrintout.php');

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	$trPrintout = new TRPrintout();
	$trPrintout->technical_request_id = $_POST['technical_request_id'];
	$trPrintout->product_id = $_POST['product_id'];
	$trPrintout->process();
	$trPrintout->printPDF();
?>