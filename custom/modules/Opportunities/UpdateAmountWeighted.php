<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Opportunities&action=UpdateAmountWeighted
updateAmountWeighted();

function updateAmountWeighted() {
	global $db;

	$db = DBManagerFactory::getInstance();

	$sql = "UPDATE opportunities
					LEFT JOIN opportunities_cstm
						ON opportunities.id = opportunities_cstm.id_c
					SET opportunities_cstm.amount_weighted_c = opportunities.amount * (opportunities.probability / 100)";

	echo '<pre>';
		print_r($sql);
	echo '</pre>';

	$db->query($sql);
}