<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Accounts&action=TestCalculateAnnualBudget
testCalculateAnnualBudget();

function testCalculateAnnualBudget() {
    global $db;

    $accountSQL = "SELECT * 
                    FROM accounts
                  LEFT JOIN accounts_cstm
                    ON accounts.id = accounts_cstm.id_c
                  WHERE accounts.deleted = 0";

	$accountResult = $db->query($accountSQL);

	while ($accountRow = $db->fetchByAssoc($accountResult) ) {
		$GLOBALS['log']->fatal($accountRow['id']);	
		$annual_budget = 0;

		for ($i=1; $i <= 12; $i++) { 
			$columnName = "cur_year_month" . $i . "_c";
			$annual_budget += $accountRow[$columnName];
		}
		
		// Update Account
		$updateSql = "UPDATE accounts 
			LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c
			SET accounts_cstm.annual_budget_c = {$annual_budget}
			WHERE accounts.deleted = 0
			AND accounts.id = '{$accountRow[id]}' ";

		$db->query($updateSql);
		

	} // end of while $accountRow
}