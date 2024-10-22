<?php

class AddSafetyDataSheetItemsJob implements RunnableSchedulerJob
{
	public function run($arguments)
	{
		$GLOBALS['log']->fatal("ONTRACK 1662 Data Backfill Job -- START");
		$db = DBManagerFactory::getInstance();
		$sql = "
			SELECT 
				tri_technicalrequestitems.id as tri_id,
				tri_technicalrequestitems.name as tr_item,
				tri_technicalrequestitems_cstm.distro_generated_c,
				tr_technicalrequests.id as tr_id,
				tri_technicalrequestitems.status as tri_status,
				tri_technicalrequestitems.qty as tri_qty,
				tri_technicalrequestitems.uom as tri_uom
				
			FROM
				tri_technicalrequestitems
					LEFT JOIN
				tri_technicalrequestitems_cstm ON tri_technicalrequestitems_cstm.id_c = tri_technicalrequestitems.id
					AND tri_technicalrequestitems.deleted = 0
					INNER JOIN
				tri_technicalrequestitems_tr_technicalrequests_c ON tri_technicalrequestitems_tr_technicalrequests_c.tri_technif81bstitems_idb = tri_technicalrequestitems.id
					AND tri_technicalrequestitems_tr_technicalrequests_c.deleted = 0
					INNER JOIN
				tr_technicalrequests ON tr_technicalrequests.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_techni0387equests_ida
					AND tr_technicalrequests.deleted = 0
			WHERE
				tri_technicalrequestitems.name = 'safety_data_sheet'
					AND tri_technicalrequestitems_cstm.distro_generated_c = 1
					AND tri_technicalrequestitems.deleted = 0 order by tr_technicalrequests.date_entered ASC" ;

		$result = $db->query($sql);

		while($row = $db->fetchByAssoc($result) ) {

			$countDistroItem = $this->generateGetDistroItemsQuery($row['tr_id']);

			$distroCountResult = $db->query($countDistroItem);
			$sdsDistroItemCount = $db->fetchRow($distroCountResult);

			if ($sdsDistroItemCount['distro_item_count'] < 1) {
				// Means no safety_data_sheet distro item
				// Insert new distro item
				$this->insertNewDistroItem($row);
				$GLOBALS['log']->fatal("INSERT NEW DISTRO ITEM: SAFETY DATA SHEET FOR TR {$row['tr_id']}");

			}

		}

		$GLOBALS['log']->fatal("ONTRACK 1662 Data Backfill Job -- END");
		return true;
	}

	public function setJob(SchedulersJob $job)
	{
		$this->job = $job;
	}

	private function generateGetDistroItemsQuery($trId, $queryParam = [])
	{
		$query['select'] = " SELECT COUNT(dsbtn_distributionitems.id) as distro_item_count ";
		
		$query['from'] = " FROM
			dsbtn_distribution
				LEFT JOIN
			dsbtn_distribution_cstm ON dsbtn_distribution_cstm.id_c = dsbtn_distribution.id
				INNER JOIN
			dsbtn_distributionitems_cstm ON dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = dsbtn_distribution.id
				INNER JOIN
			dsbtn_distributionitems ON dsbtn_distributionitems.id = dsbtn_distributionitems_cstm.id_c
				AND dsbtn_distributionitems.deleted = 0 ";

		$query['where'] = " WHERE
				dsbtn_distribution.deleted = 0
					AND dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trId}'
					AND dsbtn_distributionitems_cstm.distribution_item_c = 'safety_data_sheet' ";
		
		if (!empty($queryParam)) {
			$query['select'] = (array_key_exists('select', $queryParam)) ? $queryParam['select'] : $query['select'];
			$query['where'] = (array_key_exists('where', $queryParam)) ? $queryParam['where'] : $query['where'];
		}

		$queryString = $query['select'] . $query['from'] . $query['where'];
		return $queryString;
	}

	private function insertNewDistroItem($row) 
	{
		$dbInstance = DBManagerFactory::getInstance();

		$trDistributionWhere['select'] = "SELECT DISTINCT(dsbtn_distribution.id) AS distribution_id ";
		$trDistributionWhere['where'] = "  WHERE
			dsbtn_distribution.deleted = 0
				AND dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$row['tr_id']}' 
				LIMIT 1";

		$getTrDistributionQryResult = $dbInstance->query($this->generateGetDistroItemsQuery($row['tr_id'], $trDistributionWhere));
		
		while($dsbtnRow = $dbInstance->fetchByAssoc($getTrDistributionQryResult)) {
			
			$currentDistroItemRow = $this->getDistroItemRecentRow($dsbtnRow, $row['tr_id']);
			$newDistroItemRow = (int)$currentDistroItemRow + 1;
			
			$triStatus = ($row['tri_status']) == 'in_process' ? 'ready' : $row['tri_status'];
			
			$distroItemId = create_guid();
			$insertDsbtnItemTbl = "INSERT INTO `dsbtn_distributionitems` (`id`) VALUES ('{$distroItemId}')";
			$dbInstance->query($insertDsbtnItemTbl);

			$insertDistroItemCstmTbl = "
				INSERT INTO `dsbtn_distributionitems_cstm`
					(`id_c`,
					`distribution_item_c`,
					`dsbtn_distribution_id_c`,
					`qty_c`,
					`row_order_c`,
					`uom_c`,
					`status_c`)
				VALUES
					('{$distroItemId}',
					'safety_data_sheet',
					'{$dsbtnRow['distribution_id']}',
					{$row['tri_qty']},
					'{$newDistroItemRow}',
					'{$row['tri_uom']}',
					'{$triStatus}')
			";

			// $GLOBALS['log']->fatal($row['tr_id']);
			$dbInstance->query($insertDistroItemCstmTbl);
		}

		return true;
	}

	private function getDistroItemRecentRow($distroItemRow, $trId)
	{
		$dbInstance = DBManagerFactory::getInstance();

		$trDistributionWhere['select'] = "SELECT DISTINCT
			(dsbtn_distribution.id) AS distribution_id,
			dsbtn_distributionitems.id as distribution_item_id,
			dsbtn_distributionitems_cstm.distribution_item_c as distro_item,
			dsbtn_distributionitems_cstm.row_order_c as row_order
		";
		$trDistributionWhere['where'] = "  WHERE
			dsbtn_distribution.deleted = 0
				AND dsbtn_distribution.id = '{$distroItemRow['distribution_id']}'
				AND dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trId}' 
				ORDER BY dsbtn_distributionitems_cstm.row_order_c DESC
				LIMIT 1
			";
		
		$queryResult = $dbInstance->query($this->generateGetDistroItemsQuery($trId, $trDistributionWhere));
		$returnData = $dbInstance->fetchRow($queryResult);

		return $returnData['row_order'];
		
	}
}