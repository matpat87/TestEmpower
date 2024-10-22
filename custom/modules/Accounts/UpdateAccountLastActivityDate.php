<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Accounts&action=UpdateAccountLastActivityDate
updateAccountLastActivityDate();

function updateAccountLastActivityDate() {
	global $db;

	$db = DBManagerFactory::getInstance();

	$accountSQL = "SELECT * 
								  FROM accounts
								 LEFT JOIN accounts_cstm
								  ON accounts.id = accounts_cstm.id_c
								 WHERE accounts.deleted = 0";
	$accountResult = $db->query($accountSQL);

	$activityModules = ['calls', 'tasks', 'meetings', 'emails'];
	$relatedModules = ['contacts', 'opportunities', 'cases'];
	
	while($accountRow = $db->fetchByAssoc($accountResult) )
	{
		echo "NAME: {$accountRow['name']}<br>";
		echo "LAST ACTIVITY DATE: {$accountRow['last_activity_date_c']}<br>";

		$lastActivityDate = $accountRow['last_activity_date_c'];
		
		foreach ($activityModules as $activityKey => $activityValue) {
			$activitySQL = "SELECT * 
											 FROM {$activityValue}
										  WHERE deleted = 0 
											 AND parent_id = '{$accountRow['id']}'";
			$activityResult = $db->query($activitySQL);
			
			while ($activityRow = $db->fetchByAssoc($activityResult)) {
				if(!$lastActivityDate || $activityRow['date_entered'] > $lastActivityDate) {
					echo "ACTIVITY NAME: {$activityValue}<br>";
					echo "DATE ENTERED: {$activityRow['date_entered']}<br>";
					$lastActivityDate = $activityRow['date_entered'];
				}
			}
		}

		foreach ($relatedModules as $relatedKey => $relatedValue) {
			switch ($relatedValue) {
				case 'contacts':
					$singularLabel = 'contact';
					break;
				case 'cases':
					$singularLabel = 'case';
					break;
				case 'opportunities':
					$singularLabel = 'opportunity';
					break;
				default:
					break;
			}

			$relatedSQL = "SELECT {$relatedValue}.* 
										  FROM {$relatedValue} 
										 LEFT JOIN accounts_{$relatedValue}
											ON {$relatedValue}.id = accounts_{$relatedValue}.{$singularLabel}_id
										 WHERE {$relatedValue}.deleted = 0
											AND accounts_{$relatedValue}.account_id = '{$accountRow['id']}'";
			$relatedResult = $db->query($relatedSQL);

			while ($relatedRow = $db->fetchByAssoc($relatedResult)) {
				if(!$lastActivityDate || $relatedRow['date_entered'] > $lastActivityDate) {
					echo "RELATED NAME: {$relatedValue}<br>";
					echo "DATE ENTERED: {$relatedRow['date_entered']}<br>";
					$lastActivityDate = $relatedRow['date_entered'];
				}

				foreach ($activityModules as $activityKey => $activityValue) {
					$activitySQL = "SELECT * FROM {$activityValue} WHERE deleted = 0 AND parent_id = '{$relatedRow['id']}'";
					$activityResult = $db->query($activitySQL);
		
					while ($activityRow = $db->fetchByAssoc($activityResult)) {
						if(!$lastActivityDate || $activityRow['date_entered'] > $lastActivityDate) {
							echo "RELATED ACTIVITY NAME: {$relatedValue} - {$activityValue}<br>";
							echo "DATE ENTERED: {$activityRow['date_entered']}<br>";
							$lastActivityDate = $activityRow['date_entered'];
						}
					}
				}
			}
		}
		
		if($lastActivityDate && $accountRow['last_activity_date_c'] != $lastActivityDate) {
			$updateAccountSQL = "UPDATE accounts 
													LEFT JOIN accounts_cstm 
														ON accounts.id = accounts_cstm.id_c 
													SET accounts_cstm.last_activity_date_c = '{$lastActivityDate}' 
													WHERE accounts.id = '{$accountRow['id']}'";
			$db->query($updateAccountSQL);

			echo "NEW ACTIVITY DATE: {$lastActivityDate}<br>";
		}

		echo '*********<br>';
	}
}