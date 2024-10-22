<?php
	require_once('custom/entrypoints/classes/TRCoverLetterPdf.php');

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	$technical_request_id = $_POST['technical_request_id'];
	$trCoverLetter = new TRCoverLetterPdf($technical_request_id);
	$trCoverLetter->generatePDF();

?>