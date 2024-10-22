<?php
    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
    
    require_once('custom/entrypoints/classes/OppSumReport.php');

    $oppId = !empty($_REQUEST['record_id']) ? $_REQUEST['record_id'] : '';
    $oppSumReport = new OppSumReport();
    $oppSumReport->process($oppId);
    $oppSumReport->printPDF();
?>