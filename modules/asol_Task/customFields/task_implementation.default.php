<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

if ($task_type == "php_custom") {
	$focus->task_implementation = htmlspecialchars($focus->task_implementation, ENT_QUOTES, "UTF-8");
}
?>

<div id='task_implementation.default' class="yui-navset detailview_tabs yui-navset-top taskImplementationTable" style='display: block'>  
</div>