<?php

	class RegulatoryDocumentsBeforeSaveHook {
		public function saveNonDbFieldValueToSubpanel($bean, $event, $arguments)
		{
			global $log;
			
			// Trigger only when on  Create
			if (!isset($bean->fetched_row['id']) && !empty($bean->parent_id)) {

				// Parent Type value => <related module relationship name>
				$relationship = [
					'CI_CustomerItems' => 'rd_regulatorydocuments_ci_customeritems_1',
					'RMM_RawMaterialMaster' => 'rd_regulatorydocuments_rmm_rawmaterialmaster_1',
					'AOS_Products' => 'rd_regulatorydocuments_aos_products_1',
					'RRQ_RegulatoryRequests' => 'rrq_regulatoryrequests_rd_regulatorydocuments_1'
				];
				
				if (isset($relationship[$bean->parent_type])) {
					$bean->load_relationship($relationship[$bean->parent_type]); // load relationship between Documents and the selected "Related To" module
					
					$relatedToID = $bean->parent_id;
					$bean->{$relationship[$bean->parent_type]}->add($relatedToID); // Link document and the selected module

				}
				
			}
		}
	}
?>