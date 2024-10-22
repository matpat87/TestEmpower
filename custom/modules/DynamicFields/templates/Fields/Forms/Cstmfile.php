<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function get_body(&$ss, $vardef){
	$ss->assign('disableInlineEdit', 1);
	$ss->assign('hideDuplicatable', true);
	$ss->assign('hideImportable', true);
	$ss->assign('hideReportable', true);
	return $ss->fetch('custom/modules/DynamicFields/templates/Fields/Forms/Cstmfile.tpl');
 }
?>