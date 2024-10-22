<?php

class LinkCustomerIssueLotRelationshipSchedulerJob implements RunnableSchedulerJob
{
	public function run($arguments)
	{
		global $db, $log;

		$db = DBManagerFactory::getInstance();

		$sql = "SELECT cases.id
				FROM cases 
				LEFT JOIN cases_cstm 
					ON cases.id = cases_cstm.id_c
				WHERE cases.deleted = 0
					AND cases_cstm.lot_number_c <> ''
				";
		$result = $db->query($sql);

		while ($row = $db->fetchByAssoc($result)) {
			$customerIssueBean = BeanFactory::getBean('Cases', $row['id']);

			if (! $customerIssueBean->id) {
				continue;
			}

            $lotNumber = trim($customerIssueBean->lot_number_c);

            $delimiters = [' ', ',', ';', 'and', '&amp;'];
            $pattern = '/[' . implode('', array_map('preg_quote', $delimiters)) . ']/';

            $explodedLotNumbers = preg_split($pattern, $lotNumber, -1, PREG_SPLIT_NO_EMPTY);
            $number = 1;

            foreach ($explodedLotNumbers as $lotNumber) {
                $lotNumber = trim(str_ireplace('O', 0, $lotNumber));

                $lotBeanSQL = "
                        SELECT apx_lots.id 
                        FROM apx_lots 
                        WHERE apx_lots.deleted = 0 
                          AND apx_lots.name = '{$lotNumber}' 
                        ORDER BY apx_lots.date_entered 
                        DESC LIMIT 1;
                    ";

                $lotBeanId = $db->getOne($lotBeanSQL);
                $lotBean = BeanFactory::getBean('APX_Lots', $lotBeanId);

                if (! empty($lotBean->id)) {
                    $productMasterSQL = "
                        SELECT apx_lots_aos_productsaos_products_ida AS product_id
                        FROM apx_lots_aos_products_c
                        WHERE apx_lots_aos_products_c.deleted = 0
                            AND apx_lots_aos_products_c.apx_lots_aos_productsapx_lots_idb = '{$lotBean->id}'
                        ORDER BY apx_lots_aos_products_c.date_modified DESC
                        LIMIT 1
                    ";

                    $productMasterId = $db->getOne($productMasterSQL);
                    $lotProductMasterBean = BeanFactory::getBean('AOS_Products', $productMasterId);

                    if (! empty($lotProductMasterBean->id)) {
                        $customerProductMasterSQL = "
                            SELECT ci_customeritems.id 
                            FROM ci_customeritems 
                            LEFT JOIN ci_customeritems_cstm
                                ON ci_customeritems.id = ci_customeritems_cstm.id_c
                            WHERE ci_customeritems.deleted = 0
                                AND LOWER(TRIM(ci_customeritems_cstm.product_number_c)) = LOWER(TRIM('{$lotProductMasterBean->product_number_c}'))
                            ORDER BY ci_customeritems.date_entered DESC
                            LIMIT 1;
                        ";

                        $customerProductId = $db->getOne($customerProductMasterSQL);
                        $lotCustomerProductBean = BeanFactory::getBean('CI_CustomerItems', $customerProductId);

                        if (! empty($lotCustomerProductBean->id)) {
                            $lineItemBean = BeanFactory::newBean('AOS_Products_Quotes');
                            $lineItemBean->product_id = create_guid();
                            $lineItemBean->number = $number;
                            $lineItemBean->name = $lotCustomerProductBean->name;
                            $lineItemBean->set_created_by = false;
                            $lineItemBean->created_by = $customerIssueBean->created_by;
                            $lineItemBean->modified_user_id = $customerIssueBean->created_by;
                            $lineItemBean->assigned_user_id = $customerIssueBean->created_by;
                            $lineItemBean->parent_id = $customerIssueBean->id;
                            $lineItemBean->parent_type = $customerIssueBean->object_name;
                            $lineItemBean->lot_id = $lotBean->id;
                            $lineItemBean->lot_name = $lotBean->name;
                            $lineItemBean->customer_product_id = $lotCustomerProductBean->id;
                            $lineItemBean->customer_product_number = ($lotBean->name <> 'N/A') ? $lotCustomerProductBean->product_number_c : 'N/A';
                            $lineItemBean->customer_product_name = ($lotBean->name <> 'N/A') ? $lotCustomerProductBean->name : 'N/A';
                            $lineItemBean->customer_product_amount_lbs = $customerIssueBean->product_amount_lbs_c ?? 0;
                            $lineItemBean->product_unit_price = 0;
                            $lineItemBean->save(false);
                            $number++;
                        }
                    }
                }
            }
		}
		return true;
	}

	public function setJob(SchedulersJob $job)
	{
		$this->job = $job;
	}
}