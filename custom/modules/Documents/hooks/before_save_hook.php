<?php

	class BeforeSaveHook {
		public function saveNonDbFieldValueToSubpanel($bean, $event, $arguments)
		{
			$parentType = strtolower($bean->parent_type); // convert to lowercase since load_relationship is case sensitive
			$bean->load_relationship($parentType); // load relationship between Documents and the selected "Related To" module

			if(isset($bean->$parentType)) {				
				$relatedToID = $bean->parent_id;
				$bean->$parentType->add($relatedToID); // Link document and the selected module
			}
		}
	}
?>