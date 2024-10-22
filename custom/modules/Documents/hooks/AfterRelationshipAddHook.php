<?php

class DocumentsAfterRelationshipAddHook 
{
	public function handleSaveParentId($bean, $event, $arguments)
	{
		global $log, $db;
		
		if ($event == 'after_relationship_add' && !empty($arguments)) {
			
			if (empty($bean->parent_type) && empty($bean->parent_id)) {

				$parentType = $arguments['related_module'];
				$parentId = $arguments['related_id'];
	
				$db->query("UPDATE documents SET parent_type = '{$parentType}', parent_id='{$parentId}' WHERE id = '{$bean->id}'");
			}

		}
	}
}

	

	
?>
