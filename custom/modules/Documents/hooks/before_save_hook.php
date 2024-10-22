<?php
	// require('custom/modules/Documents/helpers/DocumentsHelper.php');
	class DocumentsBeforeSaveHook {
		public function saveNonDbFieldValueToSubpanel($bean, $event, $arguments)
		{
			global $log;
			
			if (!empty($bean->parent_type) && !empty($bean->parent_id)) {
				
				$linkedBean = BeanFactory::newBean($bean->parent_type);
				$linkName = customGetLinkedFieldName($bean, $linkedBean);
				
				$bean->load_relationship($linkName); // load relationship between Documents and the selected "Related To" module
	
				if(isset($bean->$linkName)) {				
					$relatedToID = $bean->parent_id;
					$bean->$linkName->add($relatedToID); // Link document and the selected module
				}
			}
		}
	}

	

	
?>
