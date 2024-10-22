<?php
	require_once('custom/entrypoints/classes/GenerateAccountProfile.php');

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
    
	$generateAccountProfileReport = new GenerateAccountProfile($_REQUEST['account_id']);
	$generateAccountProfileReport->generatePDF();
	
?>