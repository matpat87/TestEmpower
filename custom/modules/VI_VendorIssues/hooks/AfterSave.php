<?php

class VendorIssuesAfterSaveHook 
{
    function document_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
		
		if (! empty($_FILES['filename_file']) && !empty($_FILES['filename_file']['tmp_name'])) {
			
			$docBean = BeanFactory::newBean('Documents');
			$docBean->filename = $bean->filename;
			$docBean->status_id = 'Active';
			$docBean->doc_type = 'Sugar';
			$docBean->document_name = $bean->document_name;
			$docBean->assigned_user_id = $current_user->id;
			$docBean->assigned_user_name = $current_user->name;
			// $docBean->parent_type = 'ProjectTask';
			// $docBean->parent_id = $bean->id;
			$docBean->upload_source_id = $bean->id; // Used by Document.php to properly rename file based on upload source id
            $docBean->category_id = 'Other';
            $docBean->subcategory_id = 'Other_Documentation';
			$docBean->save();

			$docBean->load_relationship('vi_vendorissues_documents');

			if(isset($docBean->vi_vendorissues_documents)) {				
				$docBean->vi_vendorissues_documents->add($bean->id); // Link document and the selected module
			}

		}
    }
    
}

?>