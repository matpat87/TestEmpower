<?php

	class BeforeSaveHook {
		public function saveNonDbFieldValueToSubpanel($bean, $event, $arguments)
		{
			
			switch ($bean->parent_type) {
				case 'EHS_EHS':
					$parentType = 'ehs_ehs_documents_1';
					break;
				case 'MKT_Markets':
					$parentType = 'mkt_markets_documents_1';
					break;
				case 'OTR_OnTrack':
					$parentType = 'documents_otr_ontrack_1';
					break;
				default:
					$parentType = strtolower($bean->parent_type); // convert to lowercase since load_relationship is case sensitive
					break;
			}

			$bean->load_relationship($parentType); // load relationship between Documents and the selected "Related To" module

			if(isset($bean->$parentType)) {				
				$relatedToID = $bean->parent_id;
				$bean->$parentType->add($relatedToID); // Link document and the selected module
			}
		}
	}
?>