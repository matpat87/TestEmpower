<?php

class MigrateCustomerProductsRelatedDataJob implements RunnableSchedulerJob
{
	public function run($arguments)
	{
		$db = DBManagerFactory::getInstance();
    	$batchInsertData = [];
    
		$GLOBALS['log']->fatal("START - MIGRATE CUSTOMER PRODUCTS LINKS TO NEW REGULATORY REQUEST LINK TABLE");
		// Retrieve ALL customer products from previous relationship (SQL)
		$rrq_customeritemsSql = $db->query("
			SELECT 
				rrq_regulatoryrequests.id as rrq_regulatoryrequests_id,
				rrq_regulatoryrequests_ci_customeritems_1_c.rrq_regulatoryrequests_ci_customeritems_1ci_customeritems_idb as ci_customeritems_id,
				rrq_regulatoryrequests_ci_customeritems_1_c.date_modified
			FROM
				rrq_regulatoryrequests_ci_customeritems_1_c
					LEFT JOIN
				rrq_regulatoryrequests ON rrq_regulatoryrequests_ci_customeritems_1_c.rrq_regula436cequests_ida = rrq_regulatoryrequests.id
			WHERE
				rrq_regulatoryrequests_ci_customeritems_1_c.deleted = 0 
			ORDER BY rrq_regulatoryrequests_ci_customeritems_1_c.date_modified ASC
		");
		
		while ($row = $db->fetchByAssoc($rrq_customeritemsSql)) {
			// Insert to new relationship table
			$newId = create_guid();
			$valuesStr = implode("','", [$newId ,$row['rrq_regulatoryrequests_id'], $row['ci_customeritems_id'], $row['date_modified']]);
			$batchInsertData[] = "('{$valuesStr}')";
			
		} // End - while

		$dataString = implode(",", $batchInsertData);
		$insertQry = "INSERT INTO rrq_regulatoryrequests_ci_customeritems_2_c (
				id, 
				rrq_regula7aeaequests_ida, 
				rrq_regulatoryrequests_ci_customeritems_2ci_customeritems_idb,
				date_modified) 
			VALUES {$dataString}";

		$result = $db->query($insertQry);
		$GLOBALS['log']->fatal("END - MIGRATE CUSTOMER PRODUCTS LINKS TO NEW REGULATORY REQUEST LINK TABLE");
		return true;
	}
	
	public function setJob(SchedulersJob $job)
	{
		$this->job = $job;
	}
} // end of class