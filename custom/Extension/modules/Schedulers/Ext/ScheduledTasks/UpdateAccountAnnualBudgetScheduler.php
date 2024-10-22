<?php  
  $job_strings[] = 'UpdateAccountAnnualBudgetScheduler';

  function UpdateAccountAnnualBudgetScheduler() {
    global $db;
    
    $GLOBALS['log']->fatal("Account Annual Budget Computation Scheduler - START");

    $accountSQL = "SELECT * 
            FROM accounts
        LEFT JOIN accounts_cstm
            ON accounts.id = accounts_cstm.id_c
        WHERE accounts.deleted = 0";

    $accountResult = $db->query($accountSQL);

    while ($accountRow = $db->fetchByAssoc($accountResult) ) {
        $GLOBALS['log']->fatal("Account ID: {$accountRow['id']}");
		$annual_budget = 0;

		for ($i=1; $i <= 12; $i++) { 
			$columnName = "cur_year_month" . $i . "_c";
            $annual_budget += $accountRow[$columnName];
		}
        
        $GLOBALS['log']->fatal("Before: {$accountRow['annual_budget_c']}");

		// Update Account
		$updateSql = "UPDATE accounts 
			LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c
			SET accounts_cstm.annual_budget_c = {$annual_budget}
			WHERE accounts.deleted = 0
			AND accounts.id = '{$accountRow['id']}' ";

		$db->query($updateSql);
		
        $GLOBALS['log']->fatal("After: {$annual_budget}");

	} // end of while $accountRow

    $GLOBALS['log']->fatal("Account Annual Budget Computation Scheduler - END");
    
    return true;
    
  }